<?php namespace Modules\Contributions\Models;

use CodeIgniter\Model;

class ContributionModel extends Model {
    protected $table = 'contributions';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['name', 'cost', 'created_by', 'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function viewAll() {
        $this->select('contributions.*, users.first_name, users.last_name');
        $this->where(['contributions.deleted_at' => NULL]);
        $this->join('users', 'contributions.created_by = users.id');
        return $this->get()->getResultArray();
    }

    public function viewMem() {
        $this->select('id, name, cost');
        $this->where(['deleted_at' => NULL]);
        return $this->get()->getResultArray();
    }

    public function viewPayments($id) {
        $this->select('contributions.id, name, cost, payments.amount, payments.is_approved, payments.photo, payments.contri_id');
        $this->where('payments.user_id', $id);
        $this->join('payments', 'contributions.id = payments.contri_id');
        return $this->get()->getResultArray();
    }
}