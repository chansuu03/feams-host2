<?php namespace Modules\Elections\Models;

use CodeIgniter\Model;

class ElectionModel extends Model {
    protected $table = 'elections';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['title', 'description', 'vote_start', 'vote_end', 'status' ,'deleted_at'];
    protected $useSoftDeletes = true;
  
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function active() {
        $data = $this->where('status', 'a')->first();
        return $data['id'];
    }

    public function electionPositions($id) {
        $this->select('positions.id, electoral_positions.position_name as name, electoral_positions.max_candidate');
        $this->where(['positions.election_id' => $id, 'positions.deleted_at' => null]);
        $this->join('positions', 'positions.election_id = elections.id');
        $this->join('electoral_positions', 'positions.elec_position_id = electoral_positions.id');
        return $this->get()->getResultArray();
    }

    // backup
    public function electionPositions2($id) {
        $this->select('positions.id, positions.name, positions.max_candidate');
        $this->where(['positions.election_id' => $id, 'positions.deleted_at' => null]);
        $this->join('positions', 'positions.election_id = elections.id');
        return $this->get()->getResultArray();
    }

    public function electionCandidates($id) {
        $this->select('candidates.id, users.first_name, users.last_name, platform, photo, position_id, electoral_positions.position_name as name, users.profile_pic');
        $this->where(['candidates.election_id' => $id, 'candidates.deleted_at' => NULL]);
        $this->join('candidates', 'candidates.election_id = elections.id');
        $this->join('positions', 'candidates.position_id = positions.id');
        $this->join('electoral_positions', 'positions.elec_position_id = electoral_positions.id');
        $this->join('users', 'candidates.user_id = users.id');
        return $this->get()->getResultArray();
    }
    // backup
    public function electionCandidates2($id) {
        $this->select('candidates.id, users.first_name, users.last_name, platform, photo, position_id, positions.name, users.profile_pic');
        $this->where(['candidates.election_id' => $id, 'candidates.deleted_at' => NULL]);
        $this->join('candidates', 'candidates.election_id = elections.id');
        $this->join('positions', 'candidates.position_id = positions.id');
        $this->join('users', 'candidates.user_id = users.id');
        return $this->get()->getResultArray();
    }

    public function voteCountPerPosition($id) {
        $db      = \Config\Database::connect();
        $query = $db->query("SELECT positions.name, count(1) as count FROM vote_details JOIN positions ON positions.id = vote_details.position_id WHERE election_id = ". $id ." GROUP BY position_id");
        return $query->getResult('array');
    }

    public function voteCount($id) {
        $db      = \Config\Database::connect();
        $query = $db->query('SELECT users.first_name, users.last_name, positions.id, electoral_positions.position_name, vote_details.candidate_id, count(1) as count FROM vote_details JOIN positions ON positions.id = vote_details.position_id JOIN electoral_positions on positions.elec_position_id = electoral_positions.id JOIN candidates ON candidates.id = vote_details.candidate_id JOIN users ON users.id = candidates.user_id WHERE candidates.election_id = '. $id .' GROUP BY vote_details.position_id');
        return $query->getResult('array');
    }
}