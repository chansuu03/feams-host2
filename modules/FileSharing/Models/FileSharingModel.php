<?php
namespace Modules\FileSharing\Models;

use CodeIgniter\Model;

class FileSharingModel extends Model
{
    protected $table      = 'file_sharing';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['file_name', 'size', 'extension', 'uploader', 'category' ,'visibility', 'downloads' ,'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'uploaded_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    public function getUserUpload() {
        $this->select('file_sharing.*, users. first_name, users.last_name');
        $this->where('file_sharing.deleted_at', NULL);
        $this->join('users', 'users.id = file_sharing.uploader', 'left');
        return $this->get()->getResultArray();
    }

    public function getYearOld() {
        $db      = \Config\Database::connect();
        $str = "SELECT * FROM `file_sharing` WHERE `uploaded_at`< DATE_SUB(NOW(),INTERVAL 1 YEAR) AND deleted_at = NULL";
        $query = $db->query($str);
        return $query->getResultArray();
    }

    public function getDownloads() {
        $db      = \Config\Database::connect();
        $perFile = "SELECT * FROM `file_sharing` WHERE `deleted_at` IS NULL AND `visibility` = 'for all' AND MONTH(`uploaded_at`) = MONTH(CURDATE()) ORDER BY `downloads` DESC";
        $query = $db->query($perFile);
        $data['files'] = $query->getResultArray();
        $totalCount = "SELECT COUNT(*) as totalCount FROM `file_sharing` WHERE `deleted_at` IS NULL AND `visibility` = 'for all' AND MONTH(`uploaded_at`) = MONTH(CURDATE()) ORDER BY `downloads` DESC";
        $query = $db->query($totalCount);
        $data['totalFiles'] = $query->getResultArray();
        $downloads = "SELECT sum(`downloads`) as downloads FROM `file_sharing` WHERE `deleted_at` IS NULL AND `visibility` = 'for all' AND MONTH(`uploaded_at`) = MONTH(CURDATE()) ORDER BY `downloads` DESC";
        $query = $db->query($downloads);
        $data['totalDownloads'] = $query->getResultArray();
        return $data;
    }
}