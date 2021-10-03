<?php
namespace Modules\Discussions\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Discussions\Models as Models;
use App\Models as AppModels;

class Comments2 extends BaseController
{
    function __construct() {
        $this->session = session();
        $this->threadModel = new Models\ThreadModel();
        $this->userModel = new AppModels\UserModel();
        $this->commentModel = new Models\CommentModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
    }

    public function index($thread) { 
        helper('text');
        // checking roles and permissions
        $data['perm_id'] = check_role('', '', $this->session->get('role'));
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        $threadData = $this->threadModel->where('link', $thread)->first();
        if($threadData['visibility'] != 0 && $threadData['visibility'] != $this->session->get('role')) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        if(empty($threadData)) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }

        $censoredWords = ['gago', 'tangina', 'bobo', 'tang ina', 'fuck', 'dick'];
        if($this->request->getMethod() == 'post') {
            $comment = $_POST;
            $comment['comment'] = word_censor($_POST['comment'], $censoredWords, $replacement = '****');
            $comment['user_id'] = $this->session->get('user_id');
            $comment['thread_id'] = $threadData['id'];
            $comment['comment_date'] = date('Y-m-d H:i:s');
            
            if($this->validate('comment')) {
                if($this->commentModel->save($comment)) {
                    $activityLog['user'] = $this->session->get('user_id');
                    $activityLog['description'] = 'Added comment on discussion '. $threadData['subject'];
                    $this->activityLogModel->save($activityLog);
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

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'discussions';
        $data['title'] = $threadData['subject'];
        return view('Modules\Discussions\Views\thread2', $data);
    }

    public function delete($link, $id) {
        $data['comment'] = $this->commentModel->where(['id' => $id])->first();
        $threadData = $this->threadModel->where('link', $link)->first();
        // echo '<pre>';
        // print_r($data['comment']);
        // die();
        // checking roles and permissions
        $data['perm_id'] = check_role('36', 'COMM', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            if($data['comment']['user_id'] != $this->session->get('user_id')) {
                $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
                return redirect()->to(base_url());
            } else {
                $this->deleteModel($link, $id);
                return redirect()->to(base_url('discussions/'.$threadData['link']));
                // return redirect()->to(base_url('discussions'));
            }
        }
        $this->deleteModel($link, $id);
        return redirect()->to(base_url('discussions/'.$threadData['link']));
        // return redirect()->to(base_url('discussions'));
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
    }

    private function deleteModel($link, $id) {
        $data = [
            'id' => $id,
            'deleted_by' => $this->session->get('user_id'),
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $threadData = $this->threadModel->where('link', $link)->first();
        if($this->commentModel->save($data)) {
            $activityLog['user'] = $this->session->get('user_id');
            $activityLog['description'] = 'Deleted a comment on '. $threadData['subject'];
            $this->activityLogModel->save($activityLog);
            $this->session->setFlashdata('successMsg', 'Comment deleted successfully');
            return redirect()->to(base_url('discussions/'.$threadData['link']));
            // return redirect()->back();
        } else {
            $this->session->setFlashdata('failMsg', 'Failed to delete comment');
            return redirect()->to(base_url('discussions'));
        }
    }
}