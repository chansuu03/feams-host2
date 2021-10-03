<?php namespace Modules\Payments\Models;

use CodeIgniter\Model;

class PaymentFeedbacksModel extends Model {
    protected $table = 'payment_feedbacks';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['user_id', 'subject', 'comment', 'attachment', 'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function joinNames() {
        $this->select('payment_feedbacks.id, subject, comment, attachment, users.first_name, users.last_name');
        $this->where(['payment_feedbacks.deleted_at' => NULL]);
        $this->join('users', 'users.id = payment_feedbacks.user_id');
        return $this->get()->getResultArray();
    }
}