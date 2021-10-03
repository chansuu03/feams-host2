<?php namespace Modules\Payments\Models;

use CodeIgniter\Model;

class PaymentsModel extends Model {
    protected $table = 'payments';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['user_id', 'photo', 'contri_id', 'amount', 'added_by', 'is_approved','deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function viewAll() {
        $this->select('payments.*, users.first_name, users.last_name');
        $this->where(['payments.deleted_at' => NULL]);
        $this->join('users', 'payments.user_id = users.id');
        return $this->get()->getResultArray();
    }

    public function viewMember($id) {
        $this->select('payments.*, users.first_name, users.last_name, contributions.name, contributions.cost');
        $this->where(['payments.deleted_at' => NULL, 'payments.user_id' => $id]);
        $this->join('users', 'payments.user_id = users.id');
        $this->join('contributions', 'payments.contri_id = contributions.id');
        return $this->get()->getResultArray();
    }

    public function viewOne($id) {
        $this->select('payments.*, users.first_name, users.last_name');
        $this->where(['payments.deleted_at' => NULL, 'payments.contri_id' => $id]);
        $this->join('users', 'payments.user_id = users.id');
        return $this->get()->getResultArray();
    }

    public function allPaid() {
        $this->select('amount, users.first_name, users.last_name, contributions.name, payments.created_at, payments.user_id, contri_id');
        $this->where(['payments.deleted_at' => NULL]);
        $this->join('users', 'users.id = payments.user_id');
        $this->join('contributions', 'contributions.id = payments.contri_id');
        return $this->get()->getResultArray();
    }
}