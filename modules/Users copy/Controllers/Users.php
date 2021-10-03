<?php
namespace Modules\Users\Controllers;

use App\Controllers\BaseController;
use App\Models as Models;
use Modules\Files\Models as FileModels;
use Modules\Roles\Models as RoleModels;
use Modules\Payments\Models as PayModels;
use Modules\Contributions\Models as ContribModels;

class Users extends BaseController
{
    public function __construct() {
        $this->userModel = new Models\UserModel();
        $this->fileModel = new FileModels\FileModel();
        $this->payModel = new PayModels\PaymentsModel();
        $this->contriModel = new ContribModels\ContributionModel();
        $this->roleModel = new RoleModels\RoleModel();
        helper('text');
    }

    public function index() {
        $data['perm_id'] = check_role('1', 'USR', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['users'] = $this->userModel->viewing();
        $data['roles'] = $this->roleModel->findAll();
        // echo '<pre>';
        // print_r($data['users']);
        // die();
        $data['active'] = 'users';
        $data['title'] = 'Users';
        return view('Modules\Users\Views\index', $data);
    }

    public function delete($id) {
        $data['perm_id'] = check_role('6', 'ROLE', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        if($this->userModel->where('id', $id)->delete()) {
          $this->session->setFlashData('successMsg', 'Successfully deleted user');
        } else {
          $this->session->setFlashData('errorMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('admin/users'));
    }

    public function profile($username) {
        $data['perm_id'] = check_role('', '', $this->session->get('role'));
        // if(!$data['perm_id']['perm_access']) {
        //     $this->session->setFlashdata('sweetalertfail', true);
        //     return redirect()->to(base_url());
        // }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['user'] = $this->userModel->viewProfile($username);
        $data['files2'] = $this->userModel->getFileUploads($data['user']['id']);
        $data['files'] = $this->userModel->getFileSharingUploads($data['user']['id']);
        $data['contribs'] = $this->contriModel->findAll();
        $data['payments'] = $this->payModel->where(['user_id' => $data['user']['id'], 'is_approved' => '1'])->findAll();
        $data['roles'] = $this->roleModel->findAll();
        if(!empty($data['perm_id']['perm_id']['36'])) {
          $data['edit'] = true;
        }

        if($this->request->getMethod() == 'post') {
          if($this->validate('editUser')) {
            $file = $this->request->getFile('image');
            $input = $_POST;
            $input['id'] = $data['user']['id'];
            $input['profile_pic'] = $file->getRandomName();
            // checks if email is not the same anymore
            if($this->request->getVar('email') != $data['user']['email']) {
              $input['email_code'] = random_string('alnum', 5);
              $input['status'] = 'v';
            }
            if($this->request->getVar('status') == 'v'){
                $input['email_code'] = random_string('alnum', 5);
            }
            $file->move('public/uploads/profile_pic', $input['profile_pic']);
            if ($file->hasMoved()) {
                if($this->userModel->save($input)) {
                  if($input['status'] == 'v') {
                    $this->sendMail($input);
                    // kapag yung nag edit is yung user
                    if($data['user']['id'] == $this->session->get('user_id')) {
                      $this->session->setFlashData('successMsg', 'Email changed, please verify email before logging in again');
                      $this->session->destroy();
                      return redirect()->to(base_url());
                    } else {
                      // kapag admin nag edit
                      $this->session->setFlashData('successMsg', 'User profile edited successfully');
                      return redirect()->back();
                    }
                  } else { //kapag hindi na edit email 
                    $this->session->setFlashData('successMsg', 'User profile edited successfully');
                    return redirect()->back();
                  }
                }
            } else {
                $this->session->setFlashData('failMsg', 'Error editing user profile, please try again.');
                return redirect()->back();
            }
          } else {
            $data['value'] = $_POST;
            $data['errors'] = $this->validation->getErrors();
          }
        }

        $data['active'] = 'users';
        $data['title'] = $data['user']['first_name'].' '. $data['user']['last_name'];
        return view('Modules\Users\Views\profile', $data);
    }

    public function changeStatus($username) {
        $data['perm_id'] = check_role('3', 'USR', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $user = $this->userModel->where('username', $username)->first();
        $data = [
            'id' => $user['id'],
            'status' => $this->request->getVar('status_'.$user['id']),
        ];
        if($this->userModel->save($data)) {
            $this->session->setFlashData('successMsg', 'Successfully changed status of '. $user['username']);
            return redirect()->to('admin/users');
        }
    }

    public function changeRole($username) {
      $data['perm_id'] = check_role('4', 'USR', $this->session->get('role'));
      if(!$data['perm_id']['perm_access']) {
          $this->session->setFlashdata('sweetalertfail', true);
          return redirect()->to(base_url());
      }
      $data['rolePermission'] = $data['perm_id']['rolePermission'];
      
      $user = $this->userModel->where('username', $username)->first();
      if(!$user) {
        $this->session->setFlashdata('sweetalertfail', true);
        return redirect()->to(base_url());
      }
      $data = [
          'id' => $user['id'],
          'status' => $this->request->getVar('status_'.$user['id']),
      ];
      if($this->userModel->save($data)) {
          $this->session->setFlashData('successMsg', 'Successfully changed status of '. $user['username']);
          return redirect()->to('admin/users');
      }
    }

    private function sendMail($userData) {
      $this->email->setTo($userData['email']);
      $this->email->setFrom('facultyea@gmail.com', 'Faculty and Employees Association');
      $this->email->setSubject('Account Confirmation');
      $message = view('regiEmail', $userData);
      $this->email->setMessage($message);
      if ($this->email->send()) 
          echo 'Email successfully sent';
      else {
          $data = $this->email->printDebugger(['headers']);
          print_r($data);
      }
    }

    public function importcsv() {
        $data['perm_id'] = check_role('3', 'USR', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }

        $input = $this->validate([
            'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
        ]);

        if (!$input) {
            $this->session->setFlashData('errorMsg', 'Please upload a file first!');
            return redirect()->to(base_url('admin/users'));
        }else{
            if($file = $this->request->getFile('file')) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('../public/csvfile', $newName);
                    $file = fopen("../public/csvfile/".$newName,"r");
                    $i = 0;
                    $numberOfFields = 11;

                    $csvArr = array();
                    
                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata);
                        if($i > 0 && $num == $numberOfFields){ 
                            $csvArr[$i]['first_name'] = $filedata[0];
                            $csvArr[$i]['middle_name'] = $filedata[1];
                            $csvArr[$i]['last_name'] = $filedata[2];
                            $csvArr[$i]['username'] = $filedata[3];
                            $csvArr[$i]['password'] = password_hash($filedata[4], PASSWORD_DEFAULT);
                            $csvArr[$i]['email'] = $filedata[5];
                            $csvArr[$i]['gender'] = $filedata[6];
                            $csvArr[$i]['birthdate'] = $filedata[7];
                            $csvArr[$i]['contact_number'] = $filedata[8];
                            $csvArr[$i]['role'] = $filedata[9];
                            $csvArr[$i]['status'] = $filedata[10];
                        }
                        $i++;
                    }
                    fclose($file);

                    // echo '<pre>';
                    // print_r($csvArr);
                    // die();
                    $count = 0;
                    foreach($csvArr as $userdata){
                        if($this->userModel->insert($userdata)) {
                            $count++;
                        }
                    }
                    session()->setFlashdata('successMsg', $count.' rows successfully added.');
                }else{
                    session()->setFlashdata('failMsg', 'CSV file coud not be imported.');
                }
            }else{
                session()->setFlashdata('failMsg', 'CSV file coud not be imported.');
            }
        }
        return redirect()->route('admin/users');
    }
}