<?php
namespace Modules\Reports\Controllers;

use App\Controllers\BaseController;
use App\Models as Models;
use App\Libraries as Libraries;

class LoginReport extends BaseController
{
    public function __construct() {
        $this->loginModel = new Models\LoginModel();
        $this->pdf = new Libraries\Pdf();
    }

    public function index() {
        // checking roles and permissions
        $data['perm_id'] = check_role('37', 'REPO', $this->session->get('role'));
        if(!$data['perm_id']['perm_access']) {
            $this->session->setFlashdata('sweetalertfail', 'Error accessing the page, please try again');
            return redirect()->to(base_url());
        }
        $data['rolePermission'] = $data['perm_id']['rolePermission'];
        $data['perms'] = array();
        foreach($data['rolePermission'] as $rolePerms) {
            array_push($data['perms'], $rolePerms['perm_mod']);
        }

        if($this->request->getMethod() == 'post') {
            $this->generatePDF();
        }
        $data['logins'] = $this->loginModel->withRole();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'login_repo';
        $data['title'] = 'Login Reports';
        return view('Modules\Reports\Views\login\index', $data);
    }

    public function changeTable($id) {
        if($id == '1') {
            $data['logins'] = $this->loginModel->withRole();
            return view('Modules\Reports\Views\login\table', $data);
        } elseif($id === '2') {
            $data['logins'] = $this->loginModel->thisDay();
            // echo '<pre>';
            // print_r($data['logins']);
            return view('Modules\Reports\Views\login\table', $data);
        } elseif($id == '3') {
            $data['logins'] = $this->loginModel->weekly();
            return view('Modules\Reports\Views\login\table', $data);
        } elseif($id == '4') {
            $data['logins'] = $this->loginModel->monthly();
            return view('Modules\Reports\Views\login\table', $data);
        }
    }

    public function generatePDF() {
        if($this->request->getMethod() == 'post') {
            $records = $this->request->getVar('records');
            if($records == '1') {
                $details = $this->loginModel->withRole();
            } elseif($records === '2') {
                $details = $this->loginModel->thisDay();
            } elseif($records == '3') {
                $details = $this->loginModel->weekly();
            } elseif($records == '4') {
                $details = $this->loginModel->monthly();
            }
        }
		$this->pdf->AliasNbPages();
		// $details = $this->loginModel->withRole();
		
		$date = date('F d,Y');
		$this->pdf->AddPage('l', 'Legal');
		$this->pdf->SetFont('Arial','B',12);
        if($records == '1') {
            $this->pdf->Cell(70,10,'Daily Login Reports  ['.$date.']');
        } elseif($records === '2') {
            $this->pdf->Cell(70,10,'Today Login Reports  ['.$date.']');
        } elseif($records == '3') {
            $this->pdf->Cell(70,10,'Weekly Login Reports  ['.$date.']');
        } elseif($records == '4') {
            $this->pdf->Cell(70,10,'Monthly Login Reports  ['.$date.']');
        }
		// $this->pdf->Cell(70,10,'Login Reports  ['.$date.']');
		$this->pdf->Ln();

		$this->pdf->SetFont('Arial', 'B' ,8);
		$this->pdf->SetX(55);
		$this->pdf->Cell(50,10,'First Name',1);
		$this->pdf->Cell(50,10,'Last Name',1);
		$this->pdf->Cell(50,10,'Username',1);
		$this->pdf->Cell(30,10,'Role',1);
		$this->pdf->Cell(60,10,'Login Date',1);
		$this->pdf->Ln();
		foreach($details as $detail) {
			$this->pdf->SetX(55);
			$this->pdf->SetFont('Arial', '' ,8);
			$date = date_create($detail['login_date']);
			$datelogged = date_format($date, 'F d, Y H:i:s');

			$this->pdf->Cell(50,8,$detail['first_name'],1);
			$this->pdf->Cell(50,8,$detail['last_name'],1);
			$this->pdf->Cell(50,8,$detail['username'],1);
			$this->pdf->Cell(30,8,$detail['role_name'],1);
			$this->pdf->Cell(60,8,$datelogged,1);
			$this->pdf->Ln();
		}
		$date = date('F d,Y');
        $this->response->setHeader('Content-Type', 'application/pdf');
		$this->pdf->Output('D', 'Login Report ['.$date.'].pdf'); 
    }
}