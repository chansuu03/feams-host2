<?php 
namespace Modules\PaymentMethods\Models;

use CodeIgniter\Model;

class PaymentMethodModel extends Model {
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['name', 'steps', 'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}