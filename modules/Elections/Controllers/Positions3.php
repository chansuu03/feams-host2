<?php
namespace Modules\Elections\Controllers;

use App\Controllers\BaseController;
use Modules\Elections\Models as Models;
use App\Models as AppModels;

class Positions3 extends BaseController
{
    public function __construct() {
        $this->electionModel = new Models\ElectionModel();
        $this->positionModel = new Models\PositionModel();
        $this->electoralPositionModel = new Models\ElectoralPositionModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
    }

    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('23', 'POS', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $data['elections'] = $this->electionModel->where('status', 'Application')->findAll();
        if(empty($data['elections'])) {
            $this->session->setFlashdata('activeElec', 'No elections set, please add elections first');
            return redirect()->to(base_url('admin/elections'));
        }
        $data['positions'] = $this->electoralPositionModel->viewPosName();
        // echo '<pre>';
        // print_r($data['positions']);
        // die();
        
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'positions';
        $data['title'] = 'Positions';
        return view('Modules\Elections\Views\positions\index3', $data);
    }

    public function edit($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('25', 'POS', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', true);
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $data['edit'] = false;
        $data['election'] = $this->electionModel->where(['id' => $id])->first();
        $data['electoralPosition'] = $this->electoralPositionModel->findAll();
        $data['positions'] = $this->positionModel->where(['election_id' => $id])->findAll();
        if($this->request->getMethod() == 'post') {
            if($this->validate('positions2')) {
                // echo '<pre>';
                // print_r($_POST);
                // die();
                $this->electoralPositionModel->deleteAll($id);
                foreach($_POST['position_id'] as $positions) {
                    $value = [
                        'election_id' => $_POST['election_id'],
                        'elec_position_id' => $positions
                    ];
                    $this->positionModel->save($value);
                }
                $activityLog['user'] = $this->session->get('user_id');
                $activityLog['description'] = 'Edited positions for election '.$data['election']['title'];
                $this->activityLogModel->save($activityLog);
                $this->session->setFlashData('successMsg', 'Edit position successful');
                return redirect()->to(base_url('admin/positions'));
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'positions';
        $data['title'] = 'Positions';
        return view('Modules\Elections\Views\positions\formelectoral', $data);
    }
}