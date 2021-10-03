<?php namespace Modules\Permissions\Models;

use CodeIgniter\Model;

class PermissionModel extends Model {
    protected $table = 'permissions';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['perm_mod', 'desc'];
}