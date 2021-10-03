<?php
namespace Modules\Elections\Controllers;

use App\Controllers\BaseController;
use Modules\Elections\Models as Models;
use App\Models\UserModel;

class Candidates extends BaseController
{
    public function __construct() {
        $this->candidateModel = new Models\CandidateModel();
        $this->electionModel = new Models\ElectionModel();
        $this->positionModel = new Models\PositionModel();
        $this->userModel = new UserModel();
        $this->activeElec = $this->electionModel->where('status', 'a')->first();
    }
    
    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('26', 'CAN', $this->session->get('role'));
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
        $data['candidates'] = $this->candidateModel->view($activeElec['id']);
        // echo '<pre>';
        // print_r($data['candidates']);

        // die();
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'elections';
        $data['title'] = 'Candidates';
        return view('Modules\Elections\Views\candidates\index', $data);
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
        if($activeElec <= 0) {
            $this->session->setFlashdata('activeElec', 'There are no current election.');
            return redirect()->to(base_url('admin/elections'));
        }

        $data['users'] = $this->userModel->findAll();
        $data['positions'] = $this->positionModel->view($this->activeElec['id']);
        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            // echo '<pre>';
            // print_r($_POST);
            // print_r($_FILES);
            // die();
            if($this->validate('candidates')){
                $file = $this->request->getFile('photo');
                $candi = $_POST;
                $candi['photo'] = $file->getRandomName();
                $activeElec = $this->electionModel->where('status', 'a')->first();
                $candi['election_id'] = $activeElec['id'];
                if($this->candidateModel->insert($candi)) {
                    $file->move('uploads/candidates', $candi['photo']);
                    if ($file->hasMoved()) {
                        $this->session->setFlashData('successMsg', 'Adding candidate successful');
                    } else {
                        $this->session->setFlashData('failMsg', 'There is an error on adding candidate. Please try again.');
                    }
                    return redirect()->to(base_url('admin/candidates'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on adding candidate. Please try again.');
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'elections';
        $data['title'] = 'Candidates';
        return view('Modules\Elections\Views\candidates\form', $data);
    }

    public function delete($id) {
        if($this->candidateModel->delete($id)) {
          $this->session->setFlashData('successMsg', 'Successfully deleted candidate');
        } else {
          $this->session->setFlashData('failMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('admin/candidates'));
    }
}