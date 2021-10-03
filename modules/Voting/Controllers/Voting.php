<?php
namespace Modules\Voting\Controllers;

use App\Controllers\BaseController;
use Modules\Voting\Models as Models;
use Modules\Elections\Models as Election;

class Voting extends BaseController
{
    public function __construct() {
        $this->electionModel = new Election\ElectionModel();
        $this->positionModel = new Election\PositionModel();
        $this->candidateModel = new Election\CandidateModel();
        $this->voteModel = new Models\VoteModel();
        $this->voteDetailModel = new Models\VoteDetailModel();
    }

    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('18', 'ELEC', $this->session->get('role'));
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $data['voted'] = false;
        $data['first_voter'] = false;
        // check if there's active election or not
        $data['elecID'] = $this->electionModel->active();
        if(empty($data['elecID'])) {
            $this->session->setFlashdata('failMsg', 'There is no election right now.');
            return redirect()->to(base_url('admin/elections'));
        }
        // check if user currently voted
        if(!empty(session()->getFlashdata('firstVoter'))) {
            $data['first_voter'] = true;
            $data['votes'] = $this->voteDetailModel->candidateDetails($data['elecID'],$this->session->get('user_id'));
        }
        if(!empty($this->voteModel->where('voters_id', $this->session->get('user_id'))->first()) && $data['first_voter'] == false) {
            $data['voted'] = true;
            $data['votes'] = $this->voteDetailModel->candidateDetails($data['elecID'],$this->session->get('user_id'));
            // echo '<pre>';
            // print_r($data['votes']);
            // die();
        }

        $data['positions'] = $this->positionModel->findAll();
        if($this->request->getMethod() == 'post') {
            // save first to votes table
            $voter = [
                'election_id' => $data['elecID'],
                'voters_id' => $this->session->get('user_id'),
            ];
            if($this->voteModel->save($voter)) {
                $voterData = $this->voteModel->where(['election_id' => $data['elecID'], 'voters_id' => $this->session->get('user_id')])->first();
                // pagtapos mag save ng voter detail, isasave na votes
                foreach($data['positions'] as $position) {
                    if($this->request->getVar($position['id']) != 0) {
                        $voteData = [
                            'votes_id' => $voterData['id'],
                            'position_id' => $position['id'],
                            'candidate_id' => $this->request->getVar($position['id']),
                        ];
                    } else {
                        $voteData = [
                            'votes_id' => $voterData['id'],
                            'position_id' => $position['id'],
                            'candidate_id' => 0,
                        ];
                    }
                    $this->voteDetailModel->save($voteData);
                }
                $this->session->setFlashdata('firstVoter', 'Vote casted.');
                // return redirect()->to(base_url('admin/elections'));
                return redirect()->back();
            } else {
                $this->session->setFlashdata('failMsg', 'Vote not casted, please try again.');
                // return redirect()->to(base_url('admin/elections'));
                return redirect()->back();
            }
        }

        $data['candidates'] = $this->candidateModel->view($data['elecID']);

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'voting';
        $data['title'] = 'Voting';
        return view('Modules\Voting\Views\index', $data);
    }
}