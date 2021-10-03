<?php namespace Modules\Voting\Models;

use CodeIgniter\Model;

class VotingModel extends Model {
    protected $table = 'votes';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['voters_id', 'election_id', 'candidate_id', 'position_id' ,'date_casted'];
    protected $useSoftDeletes = false;
  
    protected $useTimestamps = true;
    protected $createdField  = 'date_casted';
    protected $updatedField;

    public function findUser($id, $elecID) {
        $data = $this->where(['voters_id' => $id, 'election_id', $elecID])->findAll();
        if(empty($data)) {
            return false;
        } else {
            return true;
        }
    }
}