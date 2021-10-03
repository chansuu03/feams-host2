<?php 
namespace Modules\Sliders\Models;

use CodeIgniter\Model;

class SliderModel extends Model {
    protected $table = 'sliders';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['title', 'description', 'image', 'uploader', 'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function viewUploader() {
        $this->select('sliders.id, title, description, image, users.first_name, users.last_name, sliders.created_at, sliders.updated_at, sliders.deleted_at');
        $this->where('sliders.deleted_at', null);
        $this->join('users', 'users.id = sliders.uploader');
        return $this->get()->getResultArray();
    }
}