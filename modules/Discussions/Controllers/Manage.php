<?php
namespace Modules\Discussions\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Discussions\Models as Models;
use Modules\Roles\Models as Roles;
// use App\Models\UserModel;
use App\Models as AppModels;

class Manage extends BaseController
{
    function __construct() {
        $this->session = session();
        $this->threadModel = new Models\ThreadModel();
        $this->commentModel = new Models\CommentModel();
        $this->roleModel = new Roles\RoleModel();
        $this->userModel = new AppModels\UserModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
    }
    
	public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('35', 'DISC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['roles'] = $this->roleModel->findAll();
        $data['threads'] = $this->threadModel->manage('0');

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'discussions';
        $data['title'] = 'Manage Discussions';
        return view('Modules\Discussions\Views\manage\manage', $data);
	}

    public function perRole($id) {
        $data['threads'] = $this->threadModel->manage($id);
        return view('Modules\Discussions\Views\manage\manageTable', $data);
    }

    public function viewComments($link) {
        // checking roles and permissions
        $data['perm_id'] = check_role('35', 'DISC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['threadData'] = $this->threadModel->where('link', $link)->first();
        $data['comments'] = $this->commentModel->viewComment($data['threadData']['id']);

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'discussions';
        $data['title'] = $data['threadData']['subject'];
        return view('Modules\Discussions\Views\manage\comments', $data);
    }

    public function delComment($link, $id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('35', 'DISC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $comment = [
            'id' => $id,
            'deleted_by' => $this->session->get('user_id'),
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $threadData = $this->threadModel->where('link', $link)->first();
        if($this->commentModel->save($comment)) {
            $activityLog['user'] = $this->session->get('user_id');
            $activityLog['description'] = 'Deleted a comment on '. $threadData['subject'];
            $this->activityLogModel->save($activityLog);
            $this->session->setFlashdata('successMsg', 'Comment deleted successfully');
            return redirect()->back();
            // return redirect()->back();
        } else {
            $this->session->setFlashdata('failMsg', 'Failed to delete comment');
            return redirect()-back();
        }
    }
}