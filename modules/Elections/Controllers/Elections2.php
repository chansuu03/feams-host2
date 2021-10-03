<?php
namespace Modules\Elections\Controllers;

use App\Controllers\BaseController;
use Modules\Elections\Models as Models;
use Modules\Voting\Models as VotingModels;
use Modules\Voting2\Models as Voting2Models;
use App\Libraries as Libraries;
use App\Models as AppModels;

class Elections2 extends BaseController
{
    public function __construct() {
        $this->electionModel = new Models\ElectionModel();
        $this->positionModel = new Models\PositionModel();
        $this->candidateModel = new Models\CandidateModel();
        $this->voteModel = new VotingModels\VoteModel();
        $this->voteDetailModel = new VotingModels\VoteDetailModel();
        $this->pdf = new Libraries\Pdf();
        $this->mpdf = new \Mpdf\Mpdf();
        $this->electoralPositionModel = new Models\ElectoralPositionModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
        $this->userModel = new AppModels\UserModel();
        $this->vote2Model = new Voting2Models\VoteModel();
        $this->voteDetail2Model = new Voting2Models\VoteDetailModel();
        $this->officerModel = new Models\OfficerModel();

        $elections = $this->electionModel->findAll();
        foreach($this->electionModel->findAll() as $election) {
            if($election['status'] == 'Application') {
                if(strtotime($election['vote_start']) <= strtotime(date('Y-m-d H:i:s'))) {
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
        $data['perm_id'] = check_role('19', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }
        
        $data['elections'] = $this->electionModel->findAll();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'elections';
        $data['title'] = 'Elections';
        return view('Modules\Elections\Views\index', $data);
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('20', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            // echo '<pre>';
            // print_r($_POST);
            // die();
            if($this->validate('elections')){
                if($this->electionModel->save($_POST)) {
                    $activityLog['user'] = $this->session->get('user_id');
                    $activityLog['description'] = 'Added a new election';
                    $this->activityLogModel->save($activityLog);
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
        // return view('Modules\Elections\Views\form', $data);
        return view('Modules\Elections\Views\formTime', $data);
    }

    public function add2() {
        // checking roles and permissions
        $data['perm_id'] = check_role('20', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['elecPositions'] = $this->electoralPositionModel->findAll();
        $data['positions'] = $this->positionModel->findAll();
        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            if($this->validate('elections')){
                if($this->electionModel->save($_POST)) {
                    $activityLog['user'] = $this->session->get('user_id');
                    $activityLog['description'] = 'Added a new election';
                    $this->activityLogModel->save($activityLog);
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
        // return view('Modules\Elections\Views\form', $data);
        return view('Modules\Elections\Views\formTime2', $data);
    }

    public function deactivate($elecID) {
        $data = [
            'id' => $elecID,
            'status' => 'Finished',
        ];
        if($this->electionModel->save($data)) {
            $activityLog['user'] = $this->session->get('user_id');
            $activityLog['description'] = 'Finished an election';
            $this->activityLogModel->save($activityLog);
            $this->session->setFlashdata('successMsg', 'Successfully finished an election');
            return redirect()->to(base_url('admin/elections'));
        } else {
            $this->session->setFlashdata('failMsg', 'Failed to finished an election');
            return redirect()->to(base_url('admin/elections'));
        }
    }

    public function info($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('19', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['election'] = $this->electionModel->where(['id' => $id])->first();
        if(empty($data['election'])) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['positions'] =  $this->electionModel->electionPositions($id);
        $data['candidates'] = $this->electionModel->electionCandidates($id);
        $data['voteCount'] = $this->voteModel->where(['election_id' => $id])->countAllResults(false);
        $data['positionCount'] = $this->positionModel->where(['election_id' => $id])->countAllResults(false);
        $data['candidateCount'] = $this->candidateModel->where(['election_id' => $id])->countAllResults(false);
        // $data['perCandiCount'] = $this->voteDetailModel->joinVotes($id);
        $data['perCandiCount'] = $this->electionModel->voteCount($id);
        // echo '<pre>';
        // print_r($voteDetails);
        // die();
        
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'elections';
        $data['title'] = 'Election Details';
        return view('Modules\Elections\Views\details', $data);
    }
    
    public function info2($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('19', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['election'] = $this->electionModel->where(['id' => $id])->first();
        if(empty($data['election'])) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['votes'] = $this->voteDetail2Model->voteCounts($id);
        $data['voteCount'] = $this->vote2Model->perUserVote($id);
        $data['voters'] = $this->vote2Model->elecVoter($id);
        $data['users'] = $this->userModel->forVoting();

        $data['noVotes'] = array();
        $data['votersID'] = array();
        foreach($data['voters'] as $voter) {
            array_push($data['votersID'], $voter['voter_id']);
        }
        foreach($data['users'] as $user) {
            if(!in_array($user['id'], $data['votersID'])) {
                array_push($data['noVotes'], array('first_name' => $user['first_name'], 'last_name' => $user['last_name']));
            }
        }
        $data['hasOfficers'] = false;
        if(!empty($this->officerModel->viewing($id))) {
            $data['hasOfficers'] = true;
            $data['officers'] = $this->officerModel->viewing($id);
            // echo '<pre>';
            // print_r($data['officers']);
            // die();
         }
        
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'elections';
        $data['title'] = 'Election Details';
        return view('Modules\Elections\Views\info', $data);
    }

    public function generatePDF($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('19', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }

        $elecDetails = $this->electionModel->where(['id' => $id, 'status' => 'a'])->first();
        if(empty($elecDetails)) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $positions = $this->positionModel->where(['election_id' => $id])->findAll();
        $this->pdf->AddPage('P', 'Legal');
		$this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(70,10,$elecDetails['title'].' Election Reports');
        $this->pdf->Cell(47);
        $start_date = date("M d, Y", strtotime($elecDetails['start_date']));
        $end_date = date("M d, Y", strtotime($elecDetails['end_date']));
        $this->pdf->Cell(20,10,'Vote Date: '.$start_date.' - '.$end_date,0,0,'L');
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial', 'B' ,8);
        
		$this->pdf->SetX(55);
		$this->pdf->Cell(50,10,'Positions',1);
		$this->pdf->Cell(50,10,'Votes',1);
        $this->pdf->Ln();
        
        $data['voteCounts'] = $this->electionModel->voteCountPerPosition($elecDetails['id']);
        // echo '<pre>';
        // print_r($data['voteCounts']);
        // die();
		foreach($data['voteCounts'] as $voteCount) {
            $this->pdf->SetX(55);
			$this->pdf->SetFont('Arial', '' ,8);
            
			$this->pdf->Cell(50,8,$voteCount['name'],1);
			$this->pdf->Cell(50,8,$voteCount['count'],1);
			$this->pdf->Ln();
		}
        $this->pdf->SetFont('Arial', 'B' ,9);
        $this->pdf->Cell(70,10,'Voters:');
        $this->pdf->Ln();
        // voters names here
        // next yung candidates  
        $this->response->setHeader('Content-Type', 'application/pdf');
		$this->pdf->Output('D', $elecDetails['title'].' Reports.pdf'); 
    }

    public function pdf($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('19', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }

        $data['elecDetails'] = $this->electionModel->where(['id' => $id, 'status !=' => 'Application'])->first();
        if(empty($data['elecDetails'])) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        // $data['positions'] = $this->positionModel->where(['election_id' => $id])->findAll();
        $data['positions'] = $this->electoralPositionModel->positionNameOnCandidate($id);
        $data['candidates'] = $this->candidateModel->view2($id);
        $data['voteCounts'] = $this->electionModel->voteCount($data['elecDetails']['id']);
        $data['voteDetails'] = $this->voteDetailModel->findAll();
        $data['electionVotes'] = count($this->voteModel->where('election_id', $id)->findAll());
        // echo '<pre>';
        // print_r($data['electionVotes']);
        // print_r($data['candidates']);
        // print_r($data['voteDetails']);
        // die();
        $html = view('Modules\Elections\Views\pdf', $data);
        // $this->mpdf->SetHeader($elecDetails['title'].' Results|'.date('M d,Y').'|Page: {PAGENO}');
        $this->mpdf->SetHTMLHeader('
            <p style="border-bottom: 1px solid; width: 100%;">'.$data['elecDetails']['title'].' Results</p>
        ');
        $this->mpdf->SetFooter($data['elecDetails']['title']);
        $this->mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->mpdf->Output($data['elecDetails']['title'].' Results.pdf','I');
    }

    public function edit($id) {
        // return redirect()->to(current_url()); 
        // checking roles and permissions
        $data['perm_id'] = check_role('20', 'ELEC', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['id'] = $id;
        $data['value'] = $this->electionModel->where('id', $id)->first();
        $data['elecPositions'] = $this->electoralPositionModel->findAll();
        $data['positions'] = $this->positionModel->findAll();
        $data['edit'] = true;
        if($this->request->getMethod() == 'post') {
            if($this->validate('elections')){
                $_POST['id'] = $id;
                // echo '<pre>';
                // print_r($_POST);
                // die();
                if(strtotime($_POST['vote_start']) <= strtotime("now")) {
                    $_POST['status'] = 'Voting';
                } elseif(strtotime($_POST['vote_end']) <= strtotime("now")) {
                    $_POST['status'] = 'Finished';
                }
                if($this->electionModel->save($_POST)) {
                    $activityLog['user'] = $this->session->get('user_id');
                    $activityLog['description'] = 'Added a new election';
                    $this->activityLogModel->save($activityLog);
                    $this->session->setFlashdata('successMsg', 'Successfully edited an election');
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
        $data['title'] = 'Edit Elections';
        // return view('Modules\Elections\Views\form', $data);
        return view('Modules\Elections\Views\formTime2', $data);
    }

    public function saveOfficers($id) {
        if($this->request->getMethod() == 'post') {
            if($this->validate('officers')){
                $keys = array_keys($_POST);
                $data = array_map(null, $_POST,$keys);
                foreach($data as $data) {
                    $officers[] = [
                        'election_id' => $id,
                        'user_id' => $data[0], 
                        'position' => $data[1],
                        'status' => '1',
                    ];
                }
                if($this->officerModel->insertBatch($officers)) {
                    $this->session->setFlashdata('successMsg', 'Successfully elected new officers!');
                    return redirect()->to(base_url('admin/elections/'.$id));
                } else {
                    $this->session->setFlashdata('failMsg', 'Failed to elect new officer, please try again');
                    return redirect()->to(base_url('admin/elections/'.$id));
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
                $this->session->setFlashdata($data);
                return redirect()->to(base_url('admin/elections/'.$id));
            }
        }
    }
}