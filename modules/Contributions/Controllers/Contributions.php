<?php
namespace Modules\Contributions\Controllers;

use App\Controllers\BaseController;
use Modules\Contributions\Models as Models;
use App\Models as AppModels;

class Contributions extends BaseController
{
    public function __construct() {
        $this->contribModel = new Models\ContributionModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
        $this->userModel = new AppModels\UserModel();
        $this->payModel = new \Modules\Payments\Models\PaymentsModel();
        $this->mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
    }

    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('39', 'CONT', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['contributions']  = $this->contribModel->viewAll();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'contributions';
        $data['title'] = 'Contributions';
        return view('Modules\Contributions\Views\index', $data);
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('39', 'CONT', $this->session->get('role'));
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
        if($this->request->getMethod() == 'post') {
            if($this->validate('contributions')) {
                $_POST['created_by'] = $this->session->get('user_id');
                if($this->contribModel->insert($_POST)) {
                    $activityLog['user'] = $this->session->get('user_id');
                    $activityLog['description'] = 'Added a new contribution';
                    $this->activityLogModel->save($activityLog);
                    $this->session->setFlashData('successMsg', 'Adding contribution successful');
                    return redirect()->to(base_url('admin/contributions'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on adding contribution. Please try again.');
                    return redirect()->back()->withInput();
                }
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'contributions';
        $data['title'] = 'Contributions';
        return view('Modules\Contributions\Views\form', $data);
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
        $data['perm_id'] = check_role('39', 'PAY', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        if($this->paymentModel->where('id', $id)->delete()) {
          $activityLog['user'] = $this->session->get('user_id');
          $activityLog['description'] = 'Deleted an payment';
          $this->activityLogModel->save($activityLog);
          $this->session->setFlashData('successMsg', 'Successfully deleted payment');
        } else {
          $this->session->setFlashData('errorMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('admin/payments'));
    }

    public function print($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('39', 'CONT', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }

        $data['cont'] = $this->contribModel->where('id', $id)->first();
        $data['payments'] = $this->payModel->where('contri_id', $id)->findAll();
        $data['users'] = $this->userModel->findAll();
        // pdf generation
        $view = view('Modules\Contributions\Views\pdf', $data);
        $this->mpdf->SetHTMLHeader('
        <div style="text-align: right; font-weight: bold;">
            '.$data['cont']['name'].' Contribution Report
        </div>');
        $this->mpdf->SetHTMLFooter('
        <table width="100%">
            <tr>
                <td width="33%"></td>
                <td width="33%" align="center">Page: {PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;"><b>Date generated:</b> {DATE j-m-Y}</td>
            </tr>
        </table>');
        $this->mpdf->WriteHTML($view);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->mpdf->Output($data['cont']['name'].' Contribution Report.pdf','I');
        
        foreach($data['users'] as $user) {
            if($user['status'] == 'a') {
                $cost = 0;
                foreach($data['payments'] as $pay) {
                    if($pay['user_id'] == $user['id'] && $pay['is_approved'] == '1') {
                        $cost += $pay['amount'];
                    }
                }
                if($cost === 0) {   
                    echo 'not paid: '.$user['first_name'].' '.$user['last_name'].'<br>';
                } elseif($cost < $data['cont']['cost']) {
                    $total = $data['cont']['cost'] - $cost;
                    echo 'lack of payment('.$total.'): '.$user['first_name'].' '.$user['last_name'].'<br>';
                } elseif($cost == $data['cont']['cost']) {
                    echo 'complete payment: '.$user['first_name'].' '.$user['last_name'].'<br>';
                }
            }
        }
    }
}