<?php namespace Modules\Discussions\Models;

use CodeIgniter\Model;

class CommentModel extends Model {
    protected $table = 'comments';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['user_id', 'thread_id', 'comment', 'comment_date', 'deleted_at', 'deleted_by'];
  
    protected $useTimestamps = false;
    protected $createdField  = 'comment_date';
    protected $deletedField  = 'deleted_at';

    /*
        function to check who is the user commented in the thread
        $id - represents to the thread id
        return - array contains comment and user data
    */
    public function viewComment($id) {
        $this->select('comments.id, comments.thread_id, comments.comment, comments.comment_date, comments.deleted_at, users.first_name, users.last_name, users.username, user_id');
        $this->where(['comments.thread_id' => $id, 'comments.deleted_at'=> NULL]);
        $this->join('users', 'comments.user_id = users.id');
        return $this->get()->getResultArray();
    }
}