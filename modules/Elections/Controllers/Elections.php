<?php
namespace Modules\Elections\Controllers;

use App\Controllers\BaseController;
use Modules\Elections\Models as Models;

class Elections extends BaseController
{
    public function __construct() {
        $this->electionModel = new Models\ElectionModel();
    }
    
    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('18', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        
        $data['elections'] = $this->electionModel->findAll();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'elections';
        $data['title'] = 'Elections';
        return view('Modules\Elections\Views\index', $data);
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('18', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $activeElec = intval($this->electionModel->where('status', 'a')->countAllResults(false));
        if($activeElec >= 1) {
            $this->session->setFlashdata('activeElec', 'An election is still ongoing, please wait for it to finish before adding.');
            return redirect()->to(base_url('admin/elections'));
        }

        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            // echo '<pre>';
            // print_r($_POST);
            // die();
            if($this->validate('elections')){
                $post = $_POST;
                $post['status'] = 'a';
                if($this->electionModel->save($post)) {
                    $this->session->setFlashdata('successMsg', 'Successfully started an election');
                    return redirect()->to(base_url('admin/elections'));
                } else {
                    $this->session->setFlashdata('failMsg', 'Failed to start an election');
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'elections';
        $data['title'] = 'Add Elections';
        return view('Modules\Elections\Views\form', $data);
    }

    public function deactivate($elecID) {
        $data = [
            'id' => $elecID,
            'status' => 'i',
        ];
        if($this->electionModel->save($data)) {
            $this->session->setFlashdata('successMsg', 'Successfully deactivated an election');
            return redirect()->to(base_url('admin/elections'));
        } else {
            $this->session->setFlashdata('failMsg', 'Failed to deactivate an election');
            return redirect()->to(base_url('admin/elections'));
        }
    }
}