<?php
namespace Modules\Elections\Models;

use CodeIgniter\Model;

class ElectoralPositionModel extends Model
{
    protected $table      = 'electoral_positions';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ['position_name', 'max_candidate', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function viewPosName() {
        $this->select('positions.*, electoral_positions.position_name, electoral_positions.max_candidate');
        $this->where(['positions.deleted_at' => NULL]);
        $this->join('positions', 'positions.elec_position_id = electoral_positions.id', 'left');
        return $this->get()->getResultArray();
    }

    public function deleteAll($id) {
		return $this->db
                    ->table('positions')
                    ->where(["election_id" => $id])
                    ->delete();
	}

    public function positionNameOnCandidate($id) {
        $this->select('positions.*, electoral_positions.position_name as name, electoral_positions.max_candidate');
        $this->where(['positions.deleted_at' => NULL, 'positions.election_id' => $id]);
        $this->join('positions', 'positions.elec_position_id = electoral_positions.id', 'left');
        return $this->get()->getResultArray();
    }

    public function electionCandidates($id) {
        $db      = \Config\Database::connect();
        $sql = "SELECT candidates.*, electoral_positions.position_name as name, users.first_name, users.last_name, users.profile_pic FROM `candidates` 
        JOIN positions ON candidates.position_id=positions.id 
        JOIN users ON candidates.user_id = users.id
        JOIN electoral_positions ON positions.elec_position_id=electoral_positions.id
        WHERE candidates.election_id = ? AND candidates.deleted_at IS NULL";
        $query = $db->query($sql, $id);
        return $query->getResultArray();
    }
}