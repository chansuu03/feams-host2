<?php
namespace Modules\FileSharing\Controllers;

use App\Controllers\BaseController;
use Modules\FileSharing\Models as Models;
use App\Models as AppModels;

class FileSharing extends BaseController
{
    public function __construct() {
        $this->fileSharingModel = new Models\FileSharingModel();
        $this->activityLogModel = new AppModels\ActivityLogModel();
        $this->mpdf = new \Mpdf\Mpdf();

        $data = $this->fileSharingModel->getYearOld();
        foreach($data as $file) {
            if($this->fileSharingModel->delete($file['id'])) {
                if(file_exists('uploads/files/'.$file['category'].'/'.$file['file_name'])) {
                unlink('uploads/files/'.$file['category'].'/'.$file['file_name']);
                }
            }
        }
    }
    
    public function index() {
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

        $data['files'] = $this->fileSharingModel->getUserUpload();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'files';
        $data['title'] = 'File Sharing';
        return view('Modules\FileSharing\Views\index', $data);
    }

    public function add() {
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

        $data['edit'] = false;

        $file_taken = false;
        if($this->request->getMethod() === 'post') {
            $data['files'] = $this->fileSharingModel->getUserUpload();
            $file = $this->request->getFile('file');
            foreach($data['files'] as $files) {
                if($files['file_name'] == $_POST['name'].'.'.$file->getClientExtension()) {
                    $file_taken = true;
                }
            }
            if($this->validate('files') && !$file_taken){ 
                // $file = $this->request->getFile('file');
                $userData['extension'] = $file->getClientExtension();
                $userData['file_name'] = $_POST['name'].'.'.$userData['extension'];
                $userData['size'] = $_FILES["file"]["size"]; 
                $userData['uploader'] = $this->session->get('user_id');
                if(isset($_POST['visibility'])) {
                    $userData['visibility'] = $_POST['visibility'];
                }
                $docs = ['docx', 'txt', 'pdf', 'xlsx', 'pptx', 'csv', 'ppt', 'xml'];
                $media = ['mp3', 'wav', 'm4a', 'mid', 'wma', '3gp', 'avi', 'flv', 'm4v', 'mov', 'mp4', 'mpg'];
                $images = ['bmp', 'gif', 'jpg', 'jpeg', 'png', 'psd', 'tiff', 'svg', 'PNG', 'JPEG', 'JPG'];
                if (in_array($userData['extension'], $docs)) {
                    $userData['category'] = 'Documents';
                } elseif (in_array($userData['extension'], $media)) {
                    $userData['category'] = 'Media';
                } elseif (in_array($userData['extension'], $images)) {
                    $userData['category'] = 'Images';
                } else {
                    $userData['category'] = 'Others';
                }
                if(file_exists('public/uploads/files/'.$userData['category'].'/'.$userData['file_name'])) {
                  unlink('public/uploads/files/'.$userData['category'].'/'.$userData['file_name']);
                }
                $file->move('public/uploads/files/'.$userData['category'], $userData['file_name']);
                if ($file->hasMoved()) {
                    if($this->fileSharingModel->save($userData)) {
                        $activityLog['user'] = $this->session->get('user_id');
                        $activityLog['description'] = 'Uploaded a new file.';
                        $this->activityLogModel->save($activityLog);
                        $this->session->setFlashData('successMsg', 'Adding file successful');
                    } else {
                        $this->session->setFlashData('failMsg', 'There is an error on adding file. Please try again.');
                    }
                    return redirect()->to(base_url('file_sharing'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on adding file. Please try again.');
                }
            } else {
                if($file_taken) {
                    $this->session->setFlashData('failMsg', 'File name taken, please choose another file name.');
                }
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'files';
        $data['title'] = 'File';
        return view('Modules\FileSharing\Views\form', $data);
    }

    // backup
    public function add2() {
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

        $data['edit'] = false;

        if($this->request->getMethod() === 'post') {
            if($this->validate('files')){ 
                $file = $this->request->getFile('file');
                $userData['extension'] = $file->getClientExtension();
                $userData['file_name'] = $_POST['name'].'.'.$userData['extension'];
                $userData['size'] = $_FILES["file"]["size"]; 
                $userData['uploader'] = $this->session->get('user_id');
                if(isset($_POST['visibility'])) {
                    $userData['visibility'] = $_POST['visibility'];
                }
                $docs = ['docx', 'txt', 'pdf', 'xlsx', 'pptx', 'csv', 'ppt', 'xml'];
                $media = ['mp3', 'wav', 'm4a', 'mid', 'wma', '3gp', 'avi', 'flv', 'm4v', 'mov', 'mp4', 'mpg'];
                $images = ['bmp', 'gif', 'jpg', 'jpeg', 'png', 'psd', 'tiff', 'svg', 'PNG', 'JPEG', 'JPG'];
                if (in_array($userData['extension'], $docs)) {
                    $userData['category'] = 'Documents';
                } elseif (in_array($userData['extension'], $media)) {
                    $userData['category'] = 'Media';
                } elseif (in_array($userData['extension'], $images)) {
                    $userData['category'] = 'Images';
                } else {
                    $userData['category'] = 'Others';
                }
                // echo '<pre>';
                // print_r($userData);
                // print_r($_FILES);
                // die();
                if(file_exists('public/uploads/files/'.$userData['category'].'/'.$userData['file_name'])) {
                  unlink('public/uploads/files/'.$userData['category'].'/'.$userData['file_name']);
                }
                $file->move('public/uploads/files/'.$userData['category'], $userData['file_name']);
                if ($file->hasMoved()) {
                    if($this->fileSharingModel->save($userData)) {
                        $activityLog['user'] = $this->session->get('user_id');
                        $activityLog['description'] = 'Uploaded a new file.';
                        $this->activityLogModel->save($activityLog);
                        $this->session->setFlashData('successMsg', 'Adding file successful');
                    } else {
                        $this->session->setFlashData('failMsg', 'There is an error on adding file. Please try again.');
                    }
                    return redirect()->to(base_url('file_sharing'));
                } else {
                    $this->session->setFlashData('failMsg', 'There is an error on adding file. Please try again.');
                }
                // if($this->fileSharingModel->save($userData)) {
                //     if ($file->hasMoved()) {
                //         $this->session->setFlashData('successMsg', 'Adding file successful');
                //     } else {
                //         $this->session->setFlashData('failMsg', 'There is an error on adding file. Please try again.');
                //     }
                //     return redirect()->to(base_url('file_sharing'));
                // }
            } else {
                $data['value'] = $_POST;
                $data['errors'] = $this->validation->getErrors();
            }
        }

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'files';
        $data['title'] = 'File';
        return view('Modules\FileSharing\Views\form', $data);
    }

    // delete function pls
    public function delete($id) {
        $data = $this->fileSharingModel->where('id', $id)->first();
        // echo '<pre>';
        // print_r($data);
        // die();
        if($this->fileSharingModel->delete($id)) {
            if(file_exists('public/uploads/files/'.$data['category'].'/'.$data['file_name'])) {
              unlink('public/uploads/files/'.$data['category'].'/'.$data['file_name']);
            }
            $activityLog['user'] = $this->session->get('user_id');
            $activityLog['description'] = 'Deleted a file.';
            $this->activityLogModel->save($activityLog);
            $this->session->setFlashData('successMsg', 'Successfully deleted File');
        } else {
            $this->session->setFlashData('failMsg', 'Something went wrong!');
        }
        return redirect()->to(base_url('file_sharing'));
    }

    public function download($id) {
        $data = $this->fileSharingModel->where('id', $id)->first();
        $edited = [];
        if($data['downloads'] == NULL) {
            $edited = [
                'id' => $id,
                'downloads' => 1,
            ];
        } else {
            $edited = [
                'id' => $id,
                'downloads' => (int)$data['downloads'] + 1,
            ];
        }
        if($this->fileSharingModel->save($edited)) {
            return redirect()->to(base_url('public/uploads/files/'.$data['category'].'/'.$data['file_name']));
        } else {
            return redirect()->to(base_url('file_sharing'));
        }
    }

    public function generatePDF() {
        $data['files'] = $this->fileSharingModel->getDownloads();
        // echo '<pre>';
        // print_r($data['files']);
        // die();
        $html = view('Modules\FileSharing\Views\pdf', $data);
        // $this->mpdf->SetHeader($elecDetails['title'].' Results|'.date('M d,Y').'|Page: {PAGENO}');
        $this->mpdf->SetHTMLHeader('
            <p style="border-bottom: 1px solid; width: 100%;">Monthly File Reports FEAMS</p>
        ');
        $this->mpdf->SetFooter('Date generated: '. date('F d,Y g:ia'));
        $this->mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->mpdf->Output('Monthly File Reports.pdf','I');
    }
}