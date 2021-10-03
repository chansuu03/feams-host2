<?php
namespace Modules\Elections\Controllers;

use App\Controllers\BaseController;
use Modules\Elections\Models as Models;

class Positions extends BaseController
{
    public function __construct() {
        $this->electionModel = new Models\ElectionModel();
        $this->positionModel = new Models\PositionModel();
    }
    
    public function index() { 
        // checking roles and permissions
        $data['perm_id'] = check_role('22', 'POS', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $activeElec = intval($this->electionModel->where('status', 'a')->countAllResults(false));
        if($activeElec <= 0) {
            $this->session->setFlashdata('activeElec', 'There are no current election.');
            return redirect()->to(base_url('admin/elections'));
        }
        
        $activeElec = $this->electionModel->where('status', 'a')->first();
        $data['positions'] = $this->positionModel->view($activeElec['id']);
        // echo '<pre>';
        // print_r($data['positions']);
        // die();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'elections';
        $data['title'] = 'Positions';
        return view('Modules\Elections\Views\positions\index', $data);
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('23', 'POS', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        
        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            if($this->validate('positions')){
                $post = $_POST;
                $post['status'] = 'a';
                $post['election_id'] = $this->electionModel->active();
                if($this->positionModel->save($post)) {
                    $this->session->setFlashdata('successMsg', 'Successfully added an position');
                    return redirect()->to(base_url('admin/positions'));
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
        $data['title'] = 'Positions';
        return view('Modules\Elections\Views\positions\form', $data);
    }

    public function delete($id) {
        if($this->positionModel->delete($id)) {
          $this->session->setFlashData('successMsg', 'Successfully deleted position');
        } else {
          $this->session->setFlashData('failMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('admin/positions'));
    }
}