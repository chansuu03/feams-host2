<?php namespace Modules\Voting2\Models;

use CodeIgniter\Model;

class VoteModel extends Model {
    protected $table = 'votes2';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['election_id', 'voter_id' ,'date_casted'];
    protected $useSoftDeletes = false;
  
    protected $useTimestamps = true;
    protected $createdField  = 'date_casted';
    protected $updatedField;

    public function perUserVote($elecID) {
        $this->where('election_id', $elecID);
        return $this->countAllResults();
    }

    public function elecVoter($elecID) {
        $this->select('voter_id');
        $this->where('election_id', $elecID);
        // $this->join('users', 'users.id = votes2.voter_id');
        // echo '<pre>';
        // print_r($this->get()->getResultArray());
        // die();
        return $this->get()->getResultArray();
    }
}