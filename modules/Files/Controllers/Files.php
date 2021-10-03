<?php
namespace Modules\Files\Controllers;

use App\Controllers\BaseController;
use Modules\Files\Models as Models;

class Files extends BaseController
{
    public function __construct() {
        $this->fileModel = new Models\FileModel();
        $this->fileCategoryModel = new Models\FileCategoryModel();
    }
    
    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('31', 'FILES', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        
        $data['files'] = $this->fileModel->getUserUpload();
        $data['categories'] = $this->fileCategoryModel->findAll();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'files';
        $data['title'] = 'Files';
        return view('Modules\Files\Views\index', $data);
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('31', 'FILES', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            if($this->validate('files')){
                $file = $this->request->getFile('file');
                $userData['extension'] = $file->getClientExtension();
                $userData['name'] = $_POST['name'].'.'.$userData['extension'];
                $userData['size'] = $_FILES["file"]["size"]; 
                $userData['uploader'] = $this->session->get('user_id');
                $userData['category_id'] = $_POST['category_id'];
                if($this->fileModel->save($userData)) {
                    $file->move('uploads/files', $userData['name']);
                    if ($file->hasMoved()) {
                        $this->session->setFlashData('successMsg', 'Adding file successful');
                    } else {
                        $this->session->setFlashData('failMsg', 'There is an error on adding file. Please try again.');
                    }
                    return redirect()->to(base_url('files'));
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }
        $data['categories'] = $this->fileCategoryModel->findAll();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'files';
        $data['title'] = 'Files';
        return view('Modules\Files\Views\add', $data);
    }

    public function delete($id) {
        if($this->fileModel->delete($id)) {
          $this->session->setFlashData('successMsg', 'Successfully deleted File');
        } else {
          $this->session->setFlashData('failMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('files'));
    }
}
