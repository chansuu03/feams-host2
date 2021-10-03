<?php 
namespace Modules\Constitution\Models;

use CodeIgniter\Model;

class ConstitutionModel extends Model {
    protected $table      = 'constitutions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['area', 'content'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}