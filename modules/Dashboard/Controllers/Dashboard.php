<?php
namespace Modules\Dashboard\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Dashboard\Models as Models;

class Dashboard extends BaseController
{
	function __construct() {
		$this->dashboardModel = new Models\DashboardModel();
	}
	
	public function index() {
        $data['perm_id'] = check_role('', '', $this->session->get('role'));
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        if($this->session->get('role') != '1') {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }
		$data['userCount'] = $this->dashboardModel->allUsers();
        // echo '<pre>';
        // print_r($data['userCount']);
        // die();
		$data['fileCount'] = $this->dashboardModel->allFiles();
		$data['activeElections'] = $this->dashboardModel->activeElection();
		$data['discussions'] = $this->dashboardModel->discussions();
        // for file counts per category
        $data['fileCat'] = $this->dashboardModel->fileCategories();
        $data['fileCats'] = [];
        foreach($data['fileCat'] as $file) {
            $data['fileCats']['label'][] = $file['label'];
            $data['fileCats']['count'][] = $file['count'];
        }
        $data['fileCategories'] = json_encode($data['fileCats']);
        // overall file counts this month
        $data['files'] = $this->dashboardModel->fileCount();
        // logins count
        $data['logins'] = $this->dashboardModel->logins();
        // activity logs
        $data['activities'] = $this->dashboardModel->getActivity();
        // announcement count
        $data['announcements'] = $this->dashboardModel->announcements();
        // echo '<pre>';
        // print_r($data['announcements']);
        // die();
        
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'dashboard';
        $data['title'] = 'Dashboard';
        return view('Modules\Dashboard\Views\index', $data);
	}
}