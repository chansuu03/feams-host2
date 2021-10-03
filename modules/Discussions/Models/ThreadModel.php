<?php namespace Modules\Discussions\Models;

use CodeIgniter\Model;

class ThreadModel extends Model {
    protected $table = 'threads';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['subject', 'creator', 'visibility', 'link', 'status', 'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function viewPerRole($paginate, $role) {
        $this->select('threads.id, creator, subject, link, threads.created_at, threads.deleted_at, users.first_name, users.last_name, users.username, roles.role_name');
        $this->where(['threads.deleted_at' => NULL, 'threads.visibility' => $role]);
        $this->join('users', 'threads.creator = users.id');
        $this->join('roles', 'threads.visibility = roles.id', 'left');
        return $this->paginate($paginate, $role);
    }

    public function viewAll($paginate) {
        $this->select('threads.id, creator, subject, link, threads.created_at, threads.deleted_at, users.first_name, users.last_name, users.username, roles.role_name');
        $this->where(['threads.deleted_at' => NULL, 'threads.visibility' => '0']);
        $this->join('users', 'threads.creator = users.id');
        $this->join('roles', 'threads.visibility = roles.id', 'left');
        return $this->paginate($paginate, '0');
    }

    public function viewAdmin($paginate) {
        $this->select('threads.id, threads.subject, threads.link, threads.created_at, threads.deleted_at, users.first_name, users.last_name, users.username');
        $this->where(['threads.deleted_at' => NULL, 'threads.visibility' => '1']);
        $this->join('users', 'threads.creator = users.id');
        return $this->paginate($paginate);
    }

    public function viewUser($paginate) {
        $this->select('threads.id, threads.subject, threads.link, threads.created_at, threads.deleted_at, users.first_name, users.last_name, users.username');
        $this->where(['threads.deleted_at' => NULL, 'threads.visibility' => '2']);
        $this->join('users', 'threads.creator = users.id');
        return $this->paginate($paginate);
    }

    public function viewAllHomepage() {
        $this->select('threads.id, creator, subject, link, threads.created_at, threads.deleted_at, users.first_name, users.last_name, users.username, roles.role_name');
        $this->where(['threads.deleted_at' => NULL, 'threads.visibility' => '0']);
        $this->join('users', 'threads.creator = users.id');
        $this->join('roles', 'threads.visibility = roles.id', 'left');
        $this->limit(5);
        return $this->get()->getResultArray();
    }

    public function viewRoleHomepage($role) {
        $this->select('threads.id, creator, subject, link, threads.created_at, threads.deleted_at, users.first_name, users.last_name, users.username, roles.role_name');
        $this->where(['threads.deleted_at' => NULL, 'threads.visibility' => $role]);
        $this->join('users', 'threads.creator = users.id');
        $this->join('roles', 'threads.visibility = roles.id', 'left');
        $this->limit(5);
        return $this->get()->getResultArray();
    }

    public function manage($id) {
        $this->select('threads.id, creator, subject, link, threads.created_at, threads.deleted_at, users.first_name, users.last_name, users.username, roles.role_name');
        $this->where(['threads.deleted_at' => NULL, 'threads.visibility' => $id]);
        $this->join('users', 'threads.creator = users.id');
        $this->join('roles', 'threads.visibility = roles.id', 'left');
        return $this->get()->getResultArray();
    }
}