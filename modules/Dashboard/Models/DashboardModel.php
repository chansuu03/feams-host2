<?php 
namespace Modules\Dashboard\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function allUsers() {
        $db      = \Config\Database::connect();
        $table = $db->table('users');
        return $table->where('status', 'Active')->countAllResults(false);
    }

    public function allFiles() {
        $db      = \Config\Database::connect();
        $table = $db->table('file_sharing');
        return $table->where('deleted_at', null)->countAllResults(false);
    }

    public function logins() {
        $db      = \Config\Database::connect();
        $str = "SELECT 
        SUM(MONTH(login_date) = '1') AS 'Jan',
        SUM(MONTH(login_date) = '2') AS 'Feb',
        SUM(MONTH(login_date) = '3') AS 'Mar',
        SUM(MONTH(login_date) = '4') AS 'Apr',
        SUM(MONTH(login_date) = '5') AS 'May',
        SUM(MONTH(login_date) = '6') AS 'Jun',
        SUM(MONTH(login_date) = '7') AS 'Jul',
        SUM(MONTH(login_date) = '8') AS 'Aug',
        SUM(MONTH(login_date) = '9') AS 'Sep',
        SUM(MONTH(login_date) = '10') AS 'Oct',
        SUM(MONTH(login_date) = '11') AS 'Nov',
        SUM(MONTH(login_date) = '12') AS 'Dec',
        SUM(YEAR(login_date) = YEAR(CURDATE())) AS 'total',
        YEAR(CURDATE()) AS currentyear FROM logins WHERE YEAR(login_date) = YEAR(CURDATE())";
        $query = $db->query($str);
        return $query->getResultArray();
    }

    public function activeElection() {
        $db      = \Config\Database::connect();
        $table = $db->table('elections');
        $data['count'] = $table->where(['deleted_at' => null, 'status !=' => 'Finished'])->countAllResults(false);
        $data['list'] = $table->where(['deleted_at' => null, 'status !=' => 'Finished'])->get()->getResultArray();
        $monthQuery = 'SELECT * FROM `elections` WHERE MONTH(`vote_start`) = MONTH(CURRENT_DATE())';
        $query = $db->query($monthQuery);
        $data['months'] = $query->getResultArray();
        $voteQuery = 'SELECT elections.title, COUNT(votes.election_id) AS voteCount FROM elections LEFT JOIN votes ON elections.id = votes.election_id GROUP BY elections.id';
        $exeQuery = $db->query($voteQuery);
        $data['voteCount'] = $exeQuery->getResultArray();
        return $data;
    }

    public function discussions() {
        $db      = \Config\Database::connect();
        $table = $db->table('threads');
        return $table->where(['deleted_at' => null, 'status' => 'a', 'visibility' => '0'])->countAllResults(false);
    }

    public function fileCategories() {
        $db      = \Config\Database::connect();
        $query = $db->query("SELECT category as label, count(*) as count from file_sharing group by category");
        return $query->getResultArray();
    }

    public function fileCount() {
        $db      = \Config\Database::connect();
        $str = "SELECT 
        SUM(MONTH(uploaded_at) = '1') AS 'Jan',
        SUM(MONTH(uploaded_at) = '2') AS 'Feb',
        SUM(MONTH(uploaded_at) = '3') AS 'Mar',
        SUM(MONTH(uploaded_at) = '4') AS 'Apr',
        SUM(MONTH(uploaded_at) = '5') AS 'May',
        SUM(MONTH(uploaded_at) = '6') AS 'Jun',
        SUM(MONTH(uploaded_at) = '7') AS 'Jul',
        SUM(MONTH(uploaded_at) = '8') AS 'Aug',
        SUM(MONTH(uploaded_at) = '9') AS 'Sep',
        SUM(MONTH(uploaded_at) = '10') AS 'Oct',
        SUM(MONTH(uploaded_at) = '11') AS 'Nov',
        SUM(MONTH(uploaded_at) = '12') AS 'Dec',
        SUM(YEAR(uploaded_at) = YEAR(CURDATE())) AS 'total',
        YEAR(CURDATE()) AS currentyear FROM file_sharing WHERE YEAR(uploaded_at) = YEAR(CURDATE()) AND deleted_at is NULL";
        $query = $db->query($str);
        return $query->getResultArray();
    }

    public function getActivity() {
        $db      = \Config\Database::connect();
        $builder = $db->table('activity_log');
        $builder->select('users.first_name, users.last_name, users.username, users.profile_pic, activity_log.*');
        $builder->join('users', 'users.id = activity_log.user', 'left');
        return $builder->get()->getResultArray();
    }

    public function announcements() {
        $db      = \Config\Database::connect();
        $str = "SELECT 
        SUM(MONTH(created_at) = '1') AS 'Jan',
        SUM(MONTH(created_at) = '2') AS 'Feb',
        SUM(MONTH(created_at) = '3') AS 'Mar',
        SUM(MONTH(created_at) = '4') AS 'Apr',
        SUM(MONTH(created_at) = '5') AS 'May',
        SUM(MONTH(created_at) = '6') AS 'Jun',
        SUM(MONTH(created_at) = '7') AS 'Jul',
        SUM(MONTH(created_at) = '8') AS 'Aug',
        SUM(MONTH(created_at) = '9') AS 'Sep',
        SUM(MONTH(created_at) = '10') AS 'Oct',
        SUM(MONTH(created_at) = '11') AS 'Nov',
        SUM(MONTH(created_at) = '12') AS 'Dec',
        SUM(YEAR(created_at) = YEAR(CURDATE())) AS 'total',
        YEAR(CURDATE()) AS currentyear FROM announcements WHERE YEAR(created_at) = YEAR(CURDATE()) AND deleted_at is NULL";
        $query = $db->query($str);
        return $query->getResultArray();
    }
}