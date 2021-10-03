<?php
namespace Modules\Elections\Models;

use CodeIgniter\Model;

class OfficerModel extends Model
{
    protected $table      = 'officers';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'position', 'election_id', 'status', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function viewing($id) {
        $this->select('users.first_name, users.last_name, position, election_id, officers.status');
        $this->where('election_id', $id);
        $this->join('users', 'users.id = officers.user_id');
        return $this->get()->getResultArray();
    }
}