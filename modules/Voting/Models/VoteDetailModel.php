<?php namespace Modules\Voting\Models;

use CodeIgniter\Model;

class VoteDetailModel extends Model {
    protected $table = 'vote_details';
    protected $primaryKey = 'id';
  
    protected $useAutoIncrement = true;
    
    protected $allowedFields = ['votes_id', 'position_id' ,'candidate_id'];

    public function candidateDetails($elecID, $userID) {
        $this->select('users.first_name, users.last_name, vote_details.id, votes_id, vote_details.position_id, candidate_id, votes.voters_id, votes.election_id');
        $this->where(['votes.voters_id' => $userID, 'votes.election_id' => $elecID]);
        $this->join('candidates', 'vote_details.candidate_id = candidates.id', 'left');
        $this->join('users', 'candidates.user_id = users.id', 'left');
        $this->join('votes', 'vote_details.votes_id = votes.id', 'left');
        return $this->get()->getResultArray();
    }

    public function joinVotes($elecID) {
        $this->select('vote_details.id, votes.id, votes_id, position_id, candidate_id, election_id ,voters_id, date_casted');
        $this->where(['election_id'=> $elecID]);
        $this->join('votes', 'votes.id = vote_details.votes_id');
        return $this->get()->getResultArray();
    }
}