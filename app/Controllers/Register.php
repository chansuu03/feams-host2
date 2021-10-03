<?php namespace App\Controllers;

use App\Models as Models;

class Register extends BaseController {
    public function __construct() {
        $this->userModel = new Models\UserModel();
        $this->paymentMethodsModel = new \Modules\PaymentMethods\Models\PaymentMethodModel();
        $this->loginModel = new Models\LoginModel();
    }

    public function index() {
        $data[] = array();
        helper(['form', 'url', 'text']);
        $data['paymentMethods'] = $this->paymentMethodsModel->findAll();

        if($this->request->getMethod() == 'post') {
            if($this->validate('users')){
                $file = $this->request->getFile('image');
                $date=  date_create($_POST['birthdate']);
                $dates = date_format($date,"Y-m-d");
                $userData = $_POST;
                $userData['status'] = 'Unpaid';
                $userData['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
                $userData['birthdate'] = $dates;
                $userData['profile_pic'] = $file->getRandomName();
                $userData['role'] = '0';
                if($this->userModel->insert($userData)){
                    $file->move(ROOTPATH .'/public/uploads/profile_pic/', $userData['profile_pic']);
                    if($file->hasMoved()) {
                        if($this->sendMail($userData)) {
                            $this->session->setFlashdata('successMsg', 'Create account sucessfully, please view email for further instructions');
                            // $this->session->setFlashdata('successMsg', 'Create account sucessfully, please verify email');
                            return redirect()->to('login');
                        } else {
                            $this->session->setFlashdata('failMsg', 'Create account sucessfully, but there\'s an error in sending mail.');
                            // $this->session->setFlashdata('successMsg', 'Create account sucessfully, please verify email');
                            return redirect()->to('login');
                        }
                        $this->session->set('successMsg', 'Create account sucessfully, please view email for further instructions');
                        // $this->session->setFlashdata('successMsg', 'Create account sucessfully, please verify email');
                        return redirect()->to('login');
                    } else {
                        $this->session->set('failMsg', 'There is an error creating account');
                        // $this->session->setFlashdata('failMsg', 'There is an error creating account');
                            return redirect()->to('login');
                    }
                } else {
                    $this->session->set('failMsg', 'There is an error creating account');
                    // $this->session->setFlashdata('failMsg', 'There is an error creating account');
                    return redirect()->to('login');
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }
        return view('register/register', $data);
    }

    private function sendMail($userData) {
        $userData['paymentMethod'] = $this->paymentMethodsModel->where('id', $userData['payment_method'])->first();
        $this->email->setTo($userData['email']);
        $this->email->setFrom('facultyea@gmail.com', 'Faculty and Employees Association');
        $this->email->setSubject('Account Confirmation');
        $message = view('regiEmail', $userData);
        $this->email->setMessage($message);
        if ($this->email->send()) {
            return true;
        }
		else {
            return false;
        }
    }

    public function verifyPayment() {
        if($this->validate('memberProof')){
            $file = $this->request->getFile('proof');
            $data['proof'] = $file->getRandomName();
            $data['id'] = $_POST['user_id'];
            $data['status'] = '3';
            $file->move(ROOTPATH .'/public/uploads/proof/', $data['proof']);
            if($file->hasMoved()) {
                if($this->userModel->save($data)) {
                    $this->session->setFlashdata('successMsg', 'Proof sent, wait for the admin approval.');
                    // $this->session->setFlashdata('successMsg', 'Create account sucessfully, please verify email');
                    return redirect()->to('login');
                } else {
                    $this->session->set('failMsg', 'There is an error sending proof.');
                    // $this->session->setFlashdata('failMsg', 'There is an error creating account');
                    return redirect()->to('login');
                }
            }
        } else {
            $this->session->set('failMsg', 'Error in uploading, please login again.');
            // $this->session->setFlashdata('failMsg', 'There is an error creating account');
            return redirect()->to('login');
        }
    }
}