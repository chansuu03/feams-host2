<?php namespace App\Controllers;

use App\Models as Models;

class Login extends BaseController {
    public function __construct() {
        $this->userModel = new Models\UserModel();
        $this->loginModel = new Models\LoginModel();
    }

    public function index() {
        // $this->session->remove(['failMsg', 'successMsg']);
        if($this->request->getMethod() === 'post') {
            helper(['form']);
            //set rules validation form
            $rules = [
                'username'      => 'required|min_length[3]|max_length[50]',
                'password'      => 'required|min_length[3]|max_length[200]|validateUser[username,password]',
            ];

            if(!$this->validate($rules)) {
                $this->session->setFlashData('failMsg', 'Incorrect username or password');
                return redirect()->back()->withInput(); 
            } else {
                $user = $this->userModel->where('username', $this->request->getVar('username'))
                    ->first();
                if($user['status'] == '0') {
                    $data = [
                        'user_id' => $user['id'],
                        "role" => $user['role'],
                        "notPaid" => true,
                    ];
                    $this->session->setFlashData($data);
                    return redirect()->back()->withInput(); 
                }
                if($user['status'] == '2') {
                    $this->session->setFlashData('failMsg', 'Account deactivated, please contact admin');
                    return redirect()->back()->withInput(); 
                }
                if($user['status'] == '3') {
                    $this->session->setFlashData('successMsg', 'Currently paid, wait for the admin approval to be sent in your email');
                    return redirect()->back()->withInput(); 
                }
                if($user['status'] == '4') {
                    $this->session->setFlashData('failMsg', 'Email not verified, please verify it first before logging back in');
                    return redirect()->back()->withInput(); 
                }
                $this->setUserSession($user);
                return redirect()->to(base_url());
            }
        }
        return view('login');
    }

    private function setUserSession($user) {
        $data = [
            'user_id' => $user['id'],
            'isLoggedIn' => true,
            "role" => $user['role'],
        ];

        $this->session->set($data);
        $this->addLoginRecord($user);
        return true;
    }

    // Function that add login details to the database
    // parameters: whole row of the user data
    private function addLoginRecord($user) {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d H:i:s', time());
        $loginDetails = [
            'user_id' => $user['id'],
            'role_id' => $user['role'],
            'login_date' => $date,
            'created_at' => $date,
        ];

        if ($this->loginModel->save($loginDetails)) {
            return true;
        } else {
            die('there\'s an error');
        }
    }
    
    public function activate($code) {
        $user = $this->userModel->where('email_code', $code)->first();
        $this->session->remove(['failMsg', 'successMsg']);
        if(empty($user)) {
            $this->session->set('failMsg', 'Code error, please try again.');
            // $this->session->setFlashdata('failMsg', 'Code error, please try again.');
            return redirect()->to(base_url());
        }
        
        $data = [
            'id' => $user['id'],
            'email_code' => null,
            'status' => 'i',
        ];
        if($this->userModel->save($data)) {
            $this->session->set('successMsg', 'Account successfully activated');
            // $this->session->setFlashdata('successMsg', 'Account successfully activated');
            return redirect()->to(base_url());
        } else {
            $this->session->setFlashdata('failMsg', 'Account not activated, please try again');
            return redirect()->to(base_url());
        }
    }
}