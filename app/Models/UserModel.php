<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
  protected $table = 'users';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;
  protected $useSoftDeletes = true;

  protected $allowedFields = [
      'username',
      'password',
      'role',
      'profile_pic',
      'last_name',
      'first_name',
      'middle_name',
      'gender',
      'birthdate',
      'contact_number',
      'email',
      'status',
      'proof',
      'email_code',
      'payment_method',
      'created_at'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  public function forProfile($user_id) {
    $this->select('username, profile_pic, last_name, first_name, middle_name, gender, birthdate, contact_number, email, roles.role_name');
    $this->where('users.id', $user_id);
    $this->join('roles', 'roles.id = users.role');
    return $this->get()->getFirstRow('array');
  }

  public function viewing() {
    $this->select('users.id,username, profile_pic, last_name, first_name, middle_name, gender, birthdate, contact_number, email, proof, roles.role_name, type,status');
    $this->where('users.deleted_at', NULL);
    $this->join('roles', 'roles.id = users.role', 'left');
    $this->orderBy('id', 'DESC');
    return $this->get()->getResultArray();
  }

  public function forVoting() {
    $this->select('id, first_name, last_name');
    $this->where(['users.deleted_at' => NULL, 'users.status' => '1']);
    return $this->get()->getResultArray();
  }

  public function viewProfile($username) {
    $this->select('users.id, username, role, profile_pic, last_name, first_name, middle_name, gender, birthdate, contact_number, email, status, roles.role_name');
    $this->where('username', $username);
    $this->join('roles', 'roles.id = users.role', 'left');
    return $this->get()->getFirstRow('array');
  }
  
//   public function getFileUploads($id) {
//     $this->select('users.id, files.name, files.size, files.uploaded_at');
//     $this->where(['files.uploader' => $id, 'files.deleted_at ' => NULL]);
//     $this->join('files', 'users.id = files.uploader', 'left');
//     return $this->get()->getResultArray();
//   }

  public function getFileSharingUploads($id) {
    $this->select('users.id, file_sharing.*, file_sharing.file_name as name');
    $this->where(['file_sharing.uploader' => $id, 'file_sharing.deleted_at ' => NULL]);
    $this->join('file_sharing', 'users.id = file_sharing.uploader', 'left');
    return $this->get()->getResultArray();
  }
}