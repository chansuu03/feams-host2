<?php namespace Modules\Permissions\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model {
    protected $table = 'role_permissions';
    
    protected $allowedFields = ['role_id', 'perm_mod', 'perm_id'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function checkRole() {
        $this->select('roles.id, roles.role_name, role_permissions.perm_mod, permissions.desc');
        $this->where('role_permissions.deleted_at', null);
        $this->join('roles', 'roles.id = role_permissions.role_id');
        $this->join('permissions', 'permissions.id = role_permissions.perm_id');
        return $this->get()->getResultArray();
    }

    public function deleteAll($id) {
		return $this->db
                    ->table('role_permissions')
                    ->where(["role_id" => $id])
                    ->delete();
	}
}