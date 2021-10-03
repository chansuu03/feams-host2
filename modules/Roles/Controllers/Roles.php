<?php
namespace Modules\Roles\Controllers;

use App\Controllers\BaseController;
use App\Controllers\Roles as Control;
use Modules\Roles\Models as Models;
use Modules\Permissions\Models as Perms;
use App\Models as AppModels;

class Roles extends BaseController
{
    public function __construct() {
        $this->roleModel = new Models\RoleModel();
        $this->rolePermissionModel = new Perms\RolePermissionModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
    }

    // titignan if si user is pwede ma access yung module
    // return: access sa site (T/F)
    // nasa helpers na ito
    // public function checkRole($id, $mod) {
    //     $data['rolePermission'] = $this->rolePermissionModel->where('role_id', $this->session->get('role'))->get()->getResultArray();
    //     $access = false;
    //     $data['perm_id'] = [];
    //     $data['perm_access'] = false;
    //     foreach($data['rolePermission'] as $rolePermission) {
    //         if($rolePermission['perm_mod'] == $mod && $rolePermission['perm_id'] == $id) {
    //             $data['perm_access'] = true;
    //         }
    //         array_push($data['perm_id'], $rolePermission['perm_id']);
    //     }
    //     return $data;
    // }

    public function index() {
        $data['perm_id'] = check_role('8', 'ROLE', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }
        
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['roles'] = $this->roleModel->findAll();
        $data['active'] = 'roles';
        $data['title'] = 'Roles';
        return view('Modules\Roles\Views\index', $data);
    }

    public function add() {
        helper('text');
        $data['edit'] = false;
        $data['perm_id'] = check_role('5', 'ROLE', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        if($this->request->getMethod() == 'post') {
            if($this->validate('roles')){
                if($this->roleModel->insert($_POST)) {
                    $activityLog['user'] = $this->session->get('user_id');
                    $activityLog['description'] = 'Added a new role';
                    $this->activityLogModel->save($activityLog);
                    $this->session->setFlashData('successMsg', 'Adding role successful');
                    return redirect()->to(base_url('admin/roles'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on adding role. Please try again.');
                    return redirect()->back()->withInput();
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'roles';
        $data['title'] = 'Add Roles';
        return view('Modules\Roles\Views\form', $data);
    }

    public function delete($id) {
        $data['perm_id'] = check_role('7', 'ROLE', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        if($this->roleModel->where('id', $id)->delete()) {
            $activityLog['user'] = $this->session->get('user_id');
            $activityLog['description'] = 'Deleted a role';
            $this->activityLogModel->save($activityLog);
          $this->session->setFlashData('successMsg', 'Successfully deleted role');
        } else {
          $this->session->setFlashData('errorMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('admin/roles'));
    }
}