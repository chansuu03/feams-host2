<?php
namespace Modules\Elections\Controllers;

use App\Controllers\BaseController;
use Modules\Elections\Models as Models;
use App\Models\UserModel;

class Candidates2_copy extends BaseController
{
    public function __construct() {
        $this->candidateModel = new Models\CandidateModel();
        $this->electionModel = new Models\ElectionModel();
        $this->positionModel = new Models\PositionModel();
        $this->userModel = new UserModel();
    }
    
    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('27', 'CAN', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $activeElec = intval($this->electionModel->countAllResults(false));
        if($activeElec <= 0) {
            $this->session->setFlashdata('activeElec', 'There are no current election.');
            return redirect()->to(base_url('admin/elections'));
        }

        $data['elections'] = $this->electionModel->where(['status' => 'a'])->findAll();
        $data['candidates'] = $this->electionModel->electionCandidates('1');
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'candidates';
        $data['title'] = 'Candidates';
        return view('Modules\Elections\Views\candidates\index2', $data);
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('28', 'CAN', $this->session->get('role'));
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
        $data['firstActiveElec'] = $this->electionModel->where('status', 'Application')->first();
        
        $data['users'] = $this->userModel->findAll();
        $data['elections'] = $this->electionModel->findAll();
        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            // print_r($_FILES);
            if($this->validate('candidates')){
                // echo '<pre>';
                // print_r($_POST);
                // die();
                // get position details
                $data['selectedPos'] = $this->positionModel->where('id', $_POST['position_id'])->first();
                $data['isCandi'] = $this->candidateModel->where(['election_id' => $_POST['election_id'], 'user_id' => $_POST['user_id']])->first();
                if(!empty($data['isCandi'])) {
                    $this->session->setFlashdata('failMsg', 'User is currently a candidate');
                    return redirect()->back()->withInput();
                }
                // bilangin ilang candidates meron sa pos na yun
                $data['candiPosi'] = $this->candidateModel->where(['position_id' => $_POST['position_id']])->countAllResults(false);
                if($data['candiPosi'] == $data['selectedPos']['max_candidate']) {
                    $this->session->setFlashdata('failMsg', 'Position exceed max candidates');
                    return redirect()->back()->withInput();
                }
                $file = $this->request->getFile('photo');
                $candi = $_POST;
                $candi['photo'] = $file->getRandomName();
                // $activeElec = $this->electionModel->where('status', 'a')->first();
                // $candi['election_id'] = $activeElec['id'];
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
        return view('Modules\Elections\Views\candidates\form2', $data);
    }

    public function other($id) {
        $data['positions'] = $this->positionModel->where(['election_id' => $id])->findAll();

        return view('Modules\Elections\Views\candidates\positions', $data);
    }

    public function tables($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('27', 'CAN', $this->session->get('role'));
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['candidates'] = $this->electionModel->electionCandidates($id);
        // echo '<pre>';
        // print_r($data['candidates']);
        
        return view('Modules\Elections\Views\candidates\table', $data);
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