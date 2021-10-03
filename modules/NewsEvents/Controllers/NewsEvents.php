<?php
namespace Modules\NewsEvents\Controllers;

use App\Controllers\BaseController;
use Modules\NewsEvents\Models as Models;
use App\Models as AppModels;

class NewsEvents extends BaseController
{
    public function __construct() {
        $this->newsModel = new Models\NewsModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
    }

    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('41', 'NEWS', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            // $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to('news');
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        $data['news'] = $this->newsModel->viewAuthor();
        // echo '<pre>';
        // print_r($data['announcements']);
        // die();
        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'news';
        $data['title'] = 'News and Events';
        return view('Modules\NewsEvents\Views\index', $data);
    }

    public function newsList() {
        $data['news'] = $this->newsModel->viewAuthor();
        $data['firstNews'] = $this->newsModel->first();
        $data['title'] = 'News and Events';
        $data['active'] = 'news';
        // echo '<pre>';
        // print_r($data['firstNews']);
        // die();
        if($this->session->get('isLoggedIn')) {
            // checking roles and permissions
            $data['perm_id'] = check_role('', '', $this->session->get('role'));
            if(!$data['perm_id']['perm_access']) {
                $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
                return redirect()->to(base_url());
            }
            $data['rolePermission'] = $data['perm_id']['rolePermission'];
            $data['perms'] = array();
            foreach($data['rolePermission'] as $rolePerms) {
                array_push($data['perms'], $rolePerms['perm_mod']);
            }
            
            $data['user_details'] = user_details($this->session->get('user_id'));
            return view('Modules\NewsEvents\Views\listLogged', $data);
        } else {
            return view('Modules\NewsEvents\Views\list', $data);
        }
    }

    public function add() {
        // checking roles and permissions
        $data['perm_id'] = check_role('42', 'NEWS', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        helper('text');
        $data['edit'] = false;
        if($this->request->getMethod() == 'post') {
            if($_POST['content']=="<p><br></p>"){
                $_POST['content']= "";
            }
            if($this->validate('news')){
                $file = $this->request->getFile('image');
                $_POST['image'] = $file->getRandomName();
                $_POST['author'] = $this->session->get('user_id');
                if($this->newsModel->insert($_POST)) {
                    $file->move('public/uploads/news', $_POST['image']);
                    if ($file->hasMoved()) {
                        $activityLog['user'] = $this->session->get('user_id');
                        $activityLog['description'] = 'Added news';
                        $this->activityLogModel->save($activityLog);
                        $this->session->setFlashData('successMsg', 'Adding news successful');
                    } else {
                        $this->session->setFlashData('failMsg', 'There is an error on adding news. Please try again.');
                    }
                    return redirect()->to(base_url('admin/news'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on adding news. Please try again.');
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'news';
        $data['title'] = 'News';
        return view('Modules\NewsEvents\Views\form', $data);
    }

    public function view($id) {
        $data['news'] = $this->newsModel->where('id', $id)->first();
        $data['otherNews'] = $this->newsModel->findAll();
        if($this->session->get('isLoggedIn')) {
            // checking roles and permissions
            $data['perm_id'] = check_role('', '', $this->session->get('role'));
            $data['rolePermission'] = $data['perm_id']['rolePermission'];
            $data['perms'] = array();
            foreach($data['rolePermission'] as $rolePerms) {
                array_push($data['perms'], $rolePerms['perm_mod']);
            }
            $data['user_details'] = user_details($this->session->get('user_id'));
            $data['active'] = 'news';
            $data['title'] = $data['news']['title'];
            // die('this is for the logged in members');
            return view('Modules\NewsEvents\Views\viewLogged', $data);
        } else {
            // die('this is for the not logged in members');
            return view('Modules\NewsEvents\Views\viewNotLogged', $data);
        }
    }

    public function edit($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('17', 'SLID', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        helper('text');
        $data['edit'] = true;
        $data['value'] = $this->newsModel->where('id', $id)->first();
        $data['id'] = $data['value']['id'];
        if($this->request->getMethod() == 'post') {
            if($this->validate('news')){
                $file = $this->request->getFile('image');
                $_POST['image'] = $file->getRandomName();
                $_POST['uploader'] = $this->session->get('user_id');
                if($this->newsModel->update($data['id'], $_POST)) {
                    $file->move('public/uploads/news', $_POST['image']);
                    if ($file->hasMoved()) {
                        $activityLog['user'] = $this->session->get('user_id');
                        $activityLog['description'] = 'Edited an news';
                        $this->activityLogModel->save($activityLog);
                        $this->session->setFlashData('successMsg', 'Editing news successful.');
                    } else {
                        $this->session->setFlashData('failMsg', 'There is an error on editing news. Please try again.');
                    }
                    return redirect()->to(base_url('admin/news'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on editing news. Please try again.');
                }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'news';
        $data['title'] = 'News';
        return view('Modules\NewsEvents\Views\form', $data);
    }

    public function delete($id) {
        // checking roles and permissions
        $data['perm_id'] = check_role('42', 'NEWS', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];

        if($this->newsModel->where('id', $id)->delete()) {
          $activityLog['user'] = $this->session->get('user_id');
          $activityLog['description'] = 'Deleted an news';
          $this->activityLogModel->save($activityLog);
          $this->session->setFlashData('successMsg', 'Successfully deleted news!');
        } else {
          $this->session->setFlashData('errorMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('admin/news'));
    }
}