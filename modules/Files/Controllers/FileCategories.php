<?php
namespace Modules\Files\Controllers;

use App\Controllers\BaseController;
use Modules\Files\Models as Models;

class FileCategories extends BaseController
{
    public function __construct() {
        $this->fileCategoryModel = new Models\FileCategoryModel();
    }
    
    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('33', 'FICAT', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        
        $data['categories'] = $this->fileCategoryModel->findAll();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'filecat';
        $data['title'] = 'File Categories';
        return view('Modules\Files\Views\categories\index', $data);
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('34', 'FICAT', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        
        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            if($this->validate('fileCategory')) {
                if($this->fileCategoryModel->save($_POST)) {
                    $this->session->setFlashData('successMsg', 'Adding category successful');
                    return redirect()->to(base_url('files/categories'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on adding category. Please try again.');
                    return redirect()->to(base_url('files/categories'));
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'filecat';
        $data['title'] = 'File Category';
        return view('Modules\Files\Views\categories\form', $data);
    }

    public function delete($id) { 
        // checking roles and permissions
        $data['perm_id'] = check_role('34', 'FICAT', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        if($this->fileCategoryModel->delete($id)) {
          $this->session->setFlashData('successMsg', 'Successfully deleted category');
        } else {
          $this->session->setFlashData('failMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('files/categories'));
    }
}