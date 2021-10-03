<?php 
namespace Modules\Announcements\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model {
    protected $table = 'announcements';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['title', 'description', 'image', 'uploader', 'link' ,'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function viewUploader() {
        $this->select('announcements.id, title, description, image, users.first_name, users.last_name, link, announcements.created_at, announcements.updated_at, announcements.deleted_at');
        $this->where('announcements.deleted_at', null);
        $this->join('users', 'users.id = announcements.uploader');
        return $this->get()->getResultArray();
    }
}