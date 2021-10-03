<?php
namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table      = 'logins';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'role_id', 'login_date'];

    public function withRole() {
        $this->select('users.first_name, users.last_name, users.username, roles.role_name, login_date');
        $this->join('users', 'users.id = logins.user_id');
        $this->join('roles', 'roles.id = logins.role_id');
        $this->orderBy('login_date', 'DESC');
        return $this->get()->getResultArray();
    }

    public function thisDay() {
        $date = date('Y-m-d');
        $this->select('users.first_name, users.last_name, users.username, roles.role_name, login_date');
        $this->join('users', 'users.id = logins.user_id');
        $this->join('roles', 'roles.id = logins.role_id');
        $this->where('date(login_date)', $date);
        return $this->get()->getResultArray();
        // query: SELECT users.first_name, users.last_name, users.username, roles.role_name, login_date FROM logins JOIN users on users.id = logins.user_id JOIN roles on roles.id = logins.role_id WHERE date(login_date) = DATE(NOW())
    }

    public function weekly() {
        $this->select('users.first_name, users.last_name, users.username, roles.role_name, login_date');
        $this->join('users', 'users.id = logins.user_id');
        $this->join('roles', 'roles.id = logins.role_id');
        $this->where("login_date > DATE_SUB(now(), INTERVAL 1 WEEK)", false);
        return $this->get()->getResultArray();
        // query: SELECT users.first_name, users.last_name, users.username, roles.role_name, login_date FROM logins JOIN users on users.id = logins.user_id JOIN roles on roles.id = logins.role_id WHERE login_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)
    }

    public function monthly() {
        $this->select('users.first_name, users.last_name, users.username, roles.role_name, login_date');
        $this->join('users', 'users.id = logins.user_id');
        $this->join('roles', 'roles.id = logins.role_id');
        $this->where("login_date > DATE_SUB(now(), INTERVAL 1 MONTH)", false);
        return $this->get()->getResultArray();
        // query: SELECT users.first_name, users.last_name, users.username, roles.role_name, login_date FROM logins JOIN users on users.id = logins.user_id JOIN roles on roles.id = logins.role_id WHERE login_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)
    }
}