<?php namespace Modules\Files\Models;

use CodeIgniter\Model;

class FileModel extends Model {
    protected $table = 'files';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['name', 'size', 'extension', 'uploader', 'category_id' ,'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'uploaded_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getUserUpload() {
        $this->select('users. first_name, users.last_name, files.id, files.name,files.size,files.extension,files.uploaded_at, category_id, uploader');
        $this->where('files.deleted_at', NULL);
        $this->join('users', 'users.id = files.uploader', 'left');
        return $this->get()->getResultArray();
    }
}