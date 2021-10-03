<?php
namespace Modules\Payments\Controllers;

use App\Controllers\BaseController;
use Modules\Payments\Models as Models;
use Modules\Contributions\Models as ContribModels;
use App\Models as AppModels;

class Payments extends BaseController
{
    public function __construct() {
        $this->paymentModel = new Models\PaymentsModel();
        $this->userModel = new AppModels\UserModel();
        $this->contriModel = new ContribModels\ContributionModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
        $this->paymentFeedbacksModel = new Models\PaymentFeedbacksModel();
    }

    public function index() {
        $isAdmin = false;
        // checking roles and permissions
        $data['perm_id'] = check_role('40', 'PAY', $this->session->get('role'));
        if($data['perm_id']['perm_access']) {
            // admin access
            $isAdmin = true;
            $data['payments']  = $this->paymentModel->viewAll();
            $data['contri']  = $this->contriModel->viewAll();
        } else {
            $data['payments']  = $this->paymentModel->viewMember($this->session->get('user_id'));
            // echo '<pre>';
            // print_r($data['payments']);
            // die();
            $data['contri']  = $this->contriModel->viewMem();
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }
        $data['edit'] = false;

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'payments';
        $data['title'] = 'Payments';
        if($isAdmin) {
            return view('Modules\Payments\Views\admin', $data);
        } else {
            return view('Modules\Payments\Views\index2', $data);
        }
    }

    public function adminAdd() {
        // checking roles and permissions
        $data['perm_id'] = check_role('40', 'PAY', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        helper('text');
        $data['edit'] = false;
        $data['users'] = $this->userModel->findAll();
        $data['payments'] = $this->contriModel->findAll();
        if($this->request->getMethod() == 'post') {
            if($this->validate('payments')) {
                $file = $this->request->getFile('photo');
                $_POST['photo'] = $file->getRandomName();
                $_POST['added_by'] = $this->session->get('user_id');
                $_POST['is_approved'] = '1';
                if($this->paymentModel->insert($_POST)) {
                    $file->move('public/uploads/payments', $_POST['photo']);
                    $activityLog['user'] = $this->session->get('user_id');
                    $activityLog['description'] = 'Added a new payment';
                    $this->activityLogModel->save($activityLog);
                    $this->session->setFlashData('successMsg', 'Adding payment successful');
                    return redirect()->to(base_url('payments'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on adding payment. Please try again.');
                    return redirect()->back()->withInput();
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'payments';
        $data['title'] = 'Payments';
        return view('Modules\Payments\Views\formAdmin', $data);
    }

    public function contriTable($id) {
        $data['contri']  = $this->contriModel->viewAll();
        $data['payments'] = $this->paymentModel->viewOne($id);
        // echo '<pre>';
        // print_r($data['payments']);
        // die();
        return view('Modules\Payments\Views\contriTable', $data);
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('', '', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        helper('text');
        $data['edit'] = false;
        $data['payments'] = $this->contriModel->findAll();
        if($this->request->getMethod() == 'post') {
            // echo '<pre>';
            // print_r($_POST);
            // print_r($_FILES);
            // die();
            if($this->validate('payments_member')) {
                // check if the user has paid all the contribution
                $contri = $this->contriModel->where('id', $_POST['contri_id'])->first();
                $pays = $this->paymentModel->where(['user_id' => $this->session->get('user_id'), 'contri_id' => $_POST['contri_id'], 'is_approved !=' => '0'])->findAll();
                $paid = 0;
                foreach($pays as $pay) {
                    $paid += $pay['amount'];
                }
                $paid += $_POST['amount'];
                if($paid > $contri['cost']) {
                    $this->session->setFlashData('failMsg', 'Your payment will exceed, please pay exact amount.');
                    return redirect()->back()->withInput();
                }
                $file = $this->request->getFile('photo');
                $_POST['photo'] = $file->getRandomName();
                $_POST['user_id'] = $this->session->get('user_id');
                $_POST['added_by'] = $this->session->get('user_id');
                $_POST['is_approved'] = '2';
                if($this->paymentModel->insert($_POST)) {
                    $file->move('public/uploads/payments', $_POST['photo']);
                    $contri = $this->contriModel->where('id', $_POST['contri_id'])->first();
                    $activityLog['user'] = $this->session->get('user_id');
                    $activityLog['description'] = 'Paid '. $_POST['amount'] .' for the contribution: '. $contri['name'];
                    $this->activityLogModel->save($activityLog);
                    $this->session->setFlashData('successMsg', 'Contribution paid successfully');
                    return redirect()->to(base_url('payments'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on paying contribution. Please try again.');
                    return redirect()->back()->withInput();
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'payments';
        $data['title'] = 'Payments';
        return view('Modules\Payments\Views\form', $data);
    }

    public function edit($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('17', 'SLID', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        helper('text');
        $data['edit'] = true;
        $data['value'] = $this->sliderModel->where('id', $id)->first();
        $data['id'] = $data['value']['id'];
        if($this->request->getMethod() == 'post') {
            if($this->validate('payments')){
                $file = $this->request->getFile('image');
                $slider = $_POST;
                $slider['image'] = $file->getRandomName();
                $slider['uploader'] = $this->session->get('user_id');
                if($this->sliderModel->update($data['id'], $slider)) {
                    $file->move('uploads/sliders', $slider['image']);
                    if ($file->hasMoved()) {
                        $activityLog['user'] = $this->session->get('user_id');
                        $activityLog['description'] = 'Edited an slider';
                        $this->activityLogModel->save($activityLog);
                        $this->session->setFlashData('successMsg', 'Editing slider successful.');
                    } else {
                        $this->session->setFlashData('failMsg', 'There is an error on editing slider. Please try again.');
                    }
                    return redirect()->to(base_url('admin/sliders'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on editing slider. Please try again.');
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'sliders';
        $data['title'] = 'Payments';
        return view('Modules\Payments\Views\form', $data);
    }

    public function delete($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('', '', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $payment = $this->paymentModel->where('id', $id)->first();
        if($this->paymentModel->where('id', $id)->delete()) {
          $contri = $this->contriModel->where('id', $payment['contri_id'])->first();
          $activityLog['user'] = $this->session->get('user_id');
          $activityLog['description'] = 'Deleted payment for contribution: '. $contri['name'];
          $this->activityLogModel->save($activityLog);
          $this->session->setFlashData('successMsg', 'Successfully deleted payment');
        } else {
          $this->session->setFlashData('errorMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('payments'));
    }

    public function decline($id) {
        $payment = $this->paymentModel->where('id', $id)->first();
        $payment['is_approved'] = '0';
        $payment['amount'] = '0';
        $user = $this->userModel->where('id', $payment['user_id'])->first();
        if($this->paymentModel->save($payment)) {
          $contri = $this->contriModel->where('id', $payment['contri_id'])->first();
          $activityLog['user'] = $this->session->get('user_id');
          $activityLog['description'] = 'Declined payment for contribution: '. $contri['name'] . ' of '. $user['first_name'] .' ' . $user['last_name'];
          $this->activityLogModel->save($activityLog);
          $this->session->setFlashData('successMsg', 'Successfully declined payment');
        } else {
          $this->session->setFlashData('errorMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('payments'));
    }

    public function approve($id) {
        $payment = $this->paymentModel->where('id', $id)->first();
        $payment['is_approved'] = '1';
        $user = $this->userModel->where('id', $payment['user_id'])->first();
        if($this->paymentModel->save($payment)) {
          $contri = $this->contriModel->where('id', $payment['contri_id'])->first();
          $activityLog['user'] = $this->session->get('user_id');
          $activityLog['description'] = 'Approved payment for contribution: '. $contri['name'] . ' of '. $user['first_name'] .' ' . $user['last_name'];
          $this->activityLogModel->save($activityLog);
          $this->session->setFlashData('successMsg', 'Successfully approved payment');
        } else {
          $this->session->setFlashData('errorMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('payments'));
    }

    public function feedback() {
        if($this->validate('payFeedback')){
            $file = $this->request->getFile('attachment');
            if($file->isValid() &&  !$file->hasMoved()) {
                $_POST['attachment'] = $file->getRandomName();
                $file->move('public/uploads/feedbacks', $_POST['attachment']);
            }
            if($this->paymentFeedbacksModel->insert($_POST)) {
                $activityLog['user'] = $this->session->get('user_id');
                $activityLog['description'] = 'Sent a feedback';
                $this->activityLogModel->save($activityLog);
                $this->session->setFlashData('successMsg', 'Successfully sent feedback');
                return redirect()->back();
            }
        } else {
            $data['feedValue'] = $_POST;
            $data['feedErrors'] = $this->validation->getErrors();
            $this->session->setFlashdata($data);
            return redirect()->back();
        }
    }

    public function adminFeedback() {
        // checking roles and permissions
        $data['perm_id'] = check_role('40', 'PAY', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['feedbacks'] = $this->paymentFeedbacksModel->joinNames();
        // echo '<pre>';
        // print_r($data['feedbacks']);
        // die();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'payment_feedback';
        $data['title'] = 'Payment Feedbacks';
        return view('Modules\Payments\Views\adminFeedback\index', $data);
    }
}