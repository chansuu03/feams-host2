<?php namespace Modules\Voting\Models;

use CodeIgniter\Model;

class VoteModel extends Model {
    protected $table = 'votes';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['election_id', 'voters_id' ,'date_casted'];
    protected $useSoftDeletes = false;
  
    protected $useTimestamps = true;
    protected $createdField  = 'date_casted';
    protected $updatedField;
}