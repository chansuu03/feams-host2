<?php
namespace Modules\Elections\Models;

use CodeIgniter\Model;

class PositionModel extends Model
{
    protected $table      = 'positions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    // protected $allowedFields = ['name', 'election_id', 'vote_count', 'max_candidate', 'deleted_at'];
    protected $allowedFields = ['name', 'election_id', 'elec_position_id', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function view($id) {
        $this->select('positions.name, positions.id');
        $this->where(['positions.deleted_at' => NULL, 'election_id' => $id]);
        $this->join('elections', 'positions.election_id = elections.id', 'left');
        return $this->get()->getResultArray();
    }
}