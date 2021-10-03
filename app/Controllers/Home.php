<?php
namespace App\Controllers;

use App\Models as userModels;
use Modules\Announcements\Models as announceModels;
use Modules\Sliders\Models as sliderModels;
use Modules\Elections\Models as Election;
use Modules\Discussions\Models as Discussion;
use Modules\NewsEvents\Models as News;

class Home extends BaseController
{
    public function __construct() {
        $this->userModel = new userModels\UserModel();
        $this->announceModel = new announceModels\AnnouncementModel();
        $this->sliderModel = new sliderModels\SliderModel();
        $this->electionModel = new Election\ElectionModel();
        $this->threadModel = new Discussion\ThreadModel();
        $this->newsModel = new News\NewsModel();

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
        if(session()->get('isLoggedIn')) {
            $data['user'] = $this->userModel->forProfile($this->session->get('user_id'));
        }
		$data['announces'] = $this->announceModel->where('deleted_at', NULL)->orderBy('created_at', 'DESC')->get(5)->getResultArray();
		$data['sliders'] = $this->sliderModel->findAll();
		$data['allDiscussion'] = $this->threadModel->viewAllHomepage();
		$data['roleDiscussion'] = $this->threadModel->viewRoleHomepage($this->session->get('role'));
		$data['news'] = $this->newsModel->where('deleted_at', NULL)->orderBy('created_at', 'DESC')->get(5)->getResultArray();
        // echo '<pre>';
        // print_r($data['allDiscussion']);
        // die();

        $data['user_details'] = user_details($this->session->get('user_id'));
		return view('homev2', $data);
	}

    // copy of index
    public function index2() {
		$data['user'] = $this->userModel->forProfile($this->session->get('user_id'));
		$data['announces'] = $this->announceModel->findAll();
		$data['sliders'] = $this->sliderModel->findAll();
		$data['allDiscussion'] = $this->threadModel->viewAllHomepage();
		$data['roleDiscussion'] = $this->threadModel->viewRoleHomepage($this->session->get('role'));
        // echo '<pre>';
        // print_r($data['allDiscussion']);
        // die();

        $data['user_details'] = user_details($this->session->get('user_id'));
		return view('home', $data);
    }
}
