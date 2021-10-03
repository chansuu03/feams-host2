<?php 
namespace Modules\NewsEvents\Models;

use CodeIgniter\Model;

class NewsModel extends Model {
    protected $table = 'news';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['title', 'content', 'author', 'image', 'status', 'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function viewAuthor() {
        $this->select('news.id, title, content, image, news.status, news.created_at, news.updated_at, news.deleted_at, users.first_name, users.last_name');
        $this->where('news.deleted_at', null);
        $this->join('users', 'users.id = news.author');
        return $this->get()->getResultArray();
    }
}