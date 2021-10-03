<?php
namespace Modules\Discussions\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Discussions\Models as Models;
use App\Models\UserModel;

class Comments extends BaseController
{
    function __construct() {
        $this->session = session();
        $this->threadModel = new Models\ThreadModel();
        $this->userModel = new UserModel();
        $this->commentModel = new Models\CommentModel();
    }
    
	public function index($thread) {
        $threadData = $this->threadModel->where('link', $thread)->first();
        if(empty($threadData)) {
            $this->session->setFlashdata('failMsg', 'error 404');
            return redirect()->to(base_url('admin/discussions'));
        }
        // echo '<pre>';
        // print_r($comments);
        // die();
        if($this->request->getMethod() == 'post') {
            $comment = $_POST;
            $comment['user_id'] = $this->session->get('user_id');
            $comment['thread_id'] = $threadData['id'];
            $comment['comment_date'] = date('Y-m-d H:i:s');
            
            if($this->validate('comment')) {
                if($this->commentModel->save($comment)) {
                    return redirect()->back();
                }
                else {
                    $this->session->setFlashdata('failMsg', 'Failed to add comment, please try again');
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }
        $data['comments'] = $this->commentModel->viewComment($threadData['id']);
        $data['threadData'] = $threadData;
        $data['logged_in']['role'] = 1;
        $data['active'] = 'discussions';
        return view('Modules\Discussions\Views\thread', $data);
	}
}
