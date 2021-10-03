<?php
namespace Modules\Voting\Controllers;

use App\Controllers\BaseController;
use Modules\Voting\Models as Models;
use Modules\Elections\Models as Election;
use App\Models as AppModels;

class Voting3 extends BaseController
{
    public function __construct() {
        $this->electionModel = new Election\ElectionModel();
        $this->positionModel = new Election\PositionModel();
        $this->candidateModel = new Election\CandidateModel();
        $this->voteModel = new Models\VoteModel();
        $this->voteDetailModel = new Models\VoteDetailModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
        $this->electoralPositionModel = new Election\ElectoralPositionModel();

        foreach($this->electionModel->findAll() as $election) {
            if($election['status'] == 'Application') {
                if(strtotime($election['vote_start']) <= strtotime(date('Y-m-d'))) {
                    $data = [
                        'id' => $election['id'],
                        'status' => 'Voting'
                    ];
                    if($this->electionModel->save($data)) {
                        // echo $election['title'].' starts now';
                    } else {
                        // echo $election['title'].' has an error starting';
                    }
                }
            } elseif($election['status'] == 'Voting') {
                if(strtotime($election['vote_end']) <= strtotime(date('Y-m-d'))) {
                    $data = [
                        'id' => $election['id'],
                        'status' => 'Finished'
                    ];
                    if($this->electionModel->save($data)) {
                        // echo $election['title'].' end now';
                    } else {
                        // echo $election['title'].' has an error starting';
                    }
                }
            }
        }
    }

    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('', '', $this->session->get('role'));
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $activeElec = intval($this->electionModel->where('status !=', 'Application')->countAllResults(false));
        if($activeElec <= 0) {
            $this->session->setFlashdata('sweetalertfail', 'No finished and active election.');
            return redirect()->to(base_url());
        }
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['elections'] = $this->electionModel->findAll();
        // $data['elections'] = $this->electionModel->where('status !=', 'Application')->findAll();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'voting';
        $data['title'] = 'Voting';
        return view('Modules\Voting\Views\electoral\index', $data);
    }

    public function other($id) {
        $data['election'] = $this->electionModel->where(['status !=' => 'Application', 'id' => $id])->first();
        // $data['positions'] = $this->positionModel->where('election_id', $data['election']['id'])->findAll();
        $data['positions'] = $this->electoralPositionModel->positionNameOnCandidate($data['election']['id']);
        // echo '<pre>';
        // print_r($data['positions']);
        // die();
        $data['candidates'] = $this->candidateModel->view2($id);

        if($data['election']['status'] == 'Finished') {
            echo 'Election is finished, wait for the releasing of results <br>';
            // check if voted
            $voted = $this->voteModel->where(['election_id' => $id, 'voters_id' => $this->session->get('user_id')])->first();
            if(!empty($voted)) {
                echo 'You have voted for this election';
                $data['voteDetails'] = $this->voteDetailModel->where(['votes_id' => $voted['id']])->findAll();
                $data['votes'] = $this->voteDetailModel->candidateDetails($id,$this->session->get('user_id'));
                // echo '<pre>';
                // print_r($data['votes']);
                return view('Modules\Voting\Views\results2', $data);
            } else {
                echo 'You didn\'t vote for the election.';
            }
        } elseif($data['election']['status'] == 'Voting') {
            // check if voted
            $voted = $this->voteModel->where(['election_id' => $id, 'voters_id' => $this->session->get('user_id')])->first();
            if(!empty($voted)) {
                echo 'You have voted for this election';
                $data['voteDetails'] = $this->voteDetailModel->where(['votes_id' => $voted['id']])->findAll();
                $data['votes'] = $this->voteDetailModel->candidateDetails($id,$this->session->get('user_id'));
                // echo '<pre>';
                // print_r($data['votes']);
                return view('Modules\Voting\Views\results2', $data);
            } else {
                return view('Modules\Voting\Views\electoral\votingSection', $data);
            }
        }
        if(empty($data['election'])) {
            echo 'Please select an election';
        }
    }
    
    public function castVote() {
        if($this->request->getMethod() === 'post') {
            // save first to votes table
            $voter = [
                'election_id' => $this->request->getVar('election_id'),
                'voters_id' => $this->session->get('user_id'),
            ];
            if($this->voteModel->save($voter)) {
                $voterData = $this->voteModel->where(['election_id' => $voter['election_id'], 'voters_id' => $this->session->get('user_id')])->first();
                $data['electionPosition'] = $this->positionModel->where('election_id', $voter['election_id'])->findAll();
                $election = $this->electionModel->where(['id' => $voter['election_id'], 'status' => 'Voting'])->first();
                // pagtapos mag save ng voter detail, isasave na votes
                $activityLog['user'] = $this->session->get('user_id');
                $activityLog['description'] = 'Voted for the election: '.$election['title'];
                $this->activityLogModel->save($activityLog);
                foreach($data['electionPosition'] as $position) {
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
    }
}