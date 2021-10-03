<?php
namespace Modules\Reports\Controllers;

use App\Controllers\BaseController;
use App\Models as Models;
use Modules\Payments\Models as PayModels;
use Modules\Contributions\Models as ContriModels;
use App\Libraries as Libraries;

class PaymentReport extends BaseController
{
    public function __construct() {
        $this->paymentModel = new PayModels\PaymentsModel();
        $this->contriModel = new ContriModels\ContributionModel();
        $this->userModel = new Models\UserModel();
        $this->pdf = new Libraries\Pdf();
        $this->tcpdf = new Libraries\Tcpdf();
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
            $this->generatePDF($_POST);
        }
        $data['allPayments'] = $this->paymentModel->allPaid();
        $data['contributions'] = $this->contriModel->viewAll();
        // echo '<pre>';
        // print_r($data['allPayments']);
        // die();
        // echo ucwords(strtolower($data['allPayments'][0]['first_name']));
        // die();

        $data['user_details'] = user_details($this->session->get('user_id'));
        $data['active'] = 'pay_repo';
        $data['title'] = 'Payment Reports';
        return view('Modules\Reports\Views\payments\index', $data);
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

    private function generatePDF($data) {
        if($this->request->getMethod() == 'post') {
            if($_POST['type'] == '1') {
                $this->printContri($data);
            }
            if($_POST['type'] == '2') {
                $this->printPaid($data);
                // $this->generatePaid($data);
            }
            if($_POST['type'] == '3') {
                // echo '<pre>';
                // print_r($data);
                // die();
                $this->printNotPaidP($data);
                // $this->generateNotPaid($data);
            }
        }
    }

    private function printContri($data) {
        $pdf = new $this->tcpdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // die(PDF_HEADER_LOGO);
        $pdf->SetHeaderData('feamsheader.png', '130', '', '');
        $pdf->setPrintHeader(true);
        $pdf->setHeaderFont(Array('times', 'Times New Roman', PDF_FONT_SIZE_MAIN));
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );

        $data['contri'] = array();
		foreach($this->contriModel->findAll() as $contri) {
            if($contri['created_at'] >= $data['start'] && $contri['created_at'] <= $data['end']) {
                $amount = 0;
                foreach($this->paymentModel->findAll() as $pay) {
                    if($pay['contri_id'] == $contri['id']) {
                        $amount += $pay['amount'];
                    }
                }
                $date = date_create($contri['created_at']);
                $created_at = date_format($date, 'F d, Y');
                $contrib = [
                    'name' => $contri['name'],
                    'cost' => $contri['cost'].'.00',
                    'amount' => $amount.'.00',
                    'created_at' => $created_at,
                ];
                array_push($data['contri'], $contrib);
            }
		}

        $start = strtotime($data['start']);
        $end = strtotime($data['end']);
        // echo '<pre>';
        // print_r($data);
        // die();
        
        $pdf->AddPage();
        $pdf->writeHTML(view('Modules\Reports\Views\reports\list', $data), true, false, true, false, '');
        $pdf->Ln(4);
        $pdf->Output('List of contributions ['.date('m-d-Y', $start) . ' - '. date('m-d-Y', $end).'].pdf', 'I');
    }

    private function printPaid($data) {
        $pdf = new $this->tcpdf('L', 'mm', 'A4', true, 'UTF-8', false);
        // die(PDF_HEADER_LOGO);
        $pdf->SetHeaderData('feamsheader.png', '130', '', '');
        $pdf->setPrintHeader(true);
        $pdf->setHeaderFont(Array('times', 'Times New Roman', PDF_FONT_SIZE_MAIN));
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );

        $data['payments'] = array();
        $data['totalPayment'] = 0;
		foreach($this->paymentModel->allPaid() as $pay) {
            if($pay['created_at'] >= $data['start'] && $pay['created_at'] <= $data['end']) {
                $payDetails['name'] = ucwords(strtolower($pay['first_name'])).' '.ucwords(strtolower($pay['last_name']));
                $payDetails['amount'] = $pay['amount'].'.00';
                $payDetails['contriName'] = $pay['name'];
                $created_at = date_format(date_create($pay['created_at']), 'F d, Y H:ia');
                $payDetails['created_at'] = $created_at;
                array_push($data['payments'], $payDetails);
                $data['totalPayment'] += $pay['amount'];
            }
		}
        $start = strtotime($data['start']);
        $end = strtotime($data['end']);
        // echo '<pre>';
        // print_r($data);
        // die();
        
        $pdf->AddPage();
        $pdf->writeHTML(view('Modules\Reports\Views\reports\paid', $data), true, false, true, false, '');
        $pdf->Ln(4);
        $pdf->Output('List of paid for the contribution ['.date('m-d-Y', $start) . ' - '. date('m-d-Y', $end).'].pdf', 'I');
    }

    private function generatePaid($data) {
		$this->pdf->AliasNbPages();
		
		$date = date('F d,Y');
		$this->pdf->AddPage('l', 'Legal');
		$this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(70,10,'List of people who paid for contributions');
		$this->pdf->Ln();

		$this->pdf->SetFont('Arial', 'B' ,8);
		$this->pdf->SetX(55);
		$this->pdf->Cell(50,10,'User',1);
		$this->pdf->Cell(50,10,'Contribution',1);
		$this->pdf->Cell(50,10,'Amount',1);
		$this->pdf->Cell(50,10,'Date paid',1);
		$this->pdf->Ln();
		foreach($this->paymentModel->allPaid() as $pay) {
			$this->pdf->SetX(55);
			$this->pdf->SetFont('Arial', '' ,8);
            if($pay['created_at'] >= $data['start'] && $pay['created_at'] <= $data['end']) {
                $this->pdf->Cell(50,8,$pay['first_name'].' '. $pay['last_name'],1);
                $this->pdf->Cell(50,8,$pay['amount'],1);
                $this->pdf->Cell(50,8,$pay['name'],1);
                $date = date_create($pay['created_at']);
                $created_at = date_format($date, 'F d, Y H:i:s');
                $this->pdf->Cell(50,8,$created_at,1);
                $this->pdf->Ln();
            }
		}
		$date = date('F d,Y');
        $startDate = date_create($data['start']);
        $start = date_format($startDate, 'F d, Y');
        $endDate = date_create($data['end']);
        $end = date_format($endDate, 'F d, Y');
        $this->response->setHeader('Content-Type', 'application/pdf');
		$this->pdf->Output('D', 'Payment Report ['.$start.' -'. $end .'].pdf'); 
    }
    
    private function generateNotPaid($data) {
		$this->pdf->AliasNbPages();
        $contri = $this->contriModel->where('id', $data['cont'])->first();
		
		$date = date('F d,Y');
		$this->pdf->AddPage('P', 'Legal');
		$this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(70,10,'List of people who are not paid for '. $contri['name']);
		$this->pdf->Ln();

		$this->pdf->SetFont('Arial', 'B' ,8);
		// $this->pdf->SetX(55);
		// $this->pdf->Cell(50,10,'User',1);
		// $this->pdf->Ln();

        $payUser = array();
		foreach($this->paymentModel->allPaid() as $pay) {
            if($pay['contri_id'] == $contri['id']) {
                $payUser[] = $pay['user_id'];
            }
		}
        $users = $this->userModel->where('status', '1')->findAll();
        foreach($users as $user) {
            if(!in_array($user['id'], $payUser)) {
                $notPaid[] = ucwords(strtolower($user['first_name'])).' '.ucwords(strtolower($user['last_name']));
            }
        }
        $ctr = 1;
        foreach($notPaid as $not) {
            $this->pdf->Cell(70,5, $ctr.'. '.$not);
            $this->pdf->Ln();
            $ctr++;
        }
        
		$date = date('F d,Y');
        $startDate = date_create($data['start']);
        $start = date_format($startDate, 'F d, Y');
        $endDate = date_create($data['end']);
        $end = date_format($endDate, 'F d, Y');
        $this->response->setHeader('Content-Type', 'application/pdf');
		$this->pdf->Output('D', 'Payment Report ['.$start.' -'. $end .'].pdf'); 
    }

    // landscaped version
    public function printNotPaidL($data) {
        $pdf = new $this->tcpdf('L', 'mm', 'A4', true, 'UTF-8', false);
        // die(PDF_HEADER_LOGO);
        $pdf->SetHeaderData('feamsheader.png', '130', '', '');
        $pdf->setPrintHeader(true);
        $pdf->setHeaderFont(Array('times', 'Times New Roman', PDF_FONT_SIZE_MAIN));
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );

        $data['contriDetails'] = $this->contriModel->where('id', $data['cont'])->first();
        $payUser = array();
		foreach($this->paymentModel->allPaid() as $pay) {
            if($pay['contri_id'] == $data['cont']) {
                $payUser[] = $pay['user_id'];
            }
		}
        $users = $this->userModel->where('status', '1')->findAll();
        foreach($users as $user) {
            if(!in_array($user['id'], $payUser)) {
                $data['notPaid'][] = ucwords(strtolower($user['first_name'])).' '.ucwords(strtolower($user['last_name']));
            }
        }

        $pdf->AddPage();
        $pdf->writeHTML(view('Modules\Reports\Views\reports\notPaidL', $data), true, false, true, false, '');
        $pdf->Ln(4);
        $pdf->Output('List of not paid for the contribution - '.$data['contriDetails']['name'].'.pdf', 'I');
    }

    // portrait version
    public function printNotPaidP($data) {
        $pdf = new $this->tcpdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // die(PDF_HEADER_LOGO);
        $pdf->SetHeaderData('feamsheader.png', '130', '', '');
        $pdf->setPrintHeader(true);
        $pdf->setHeaderFont(Array('times', 'Times New Roman', PDF_FONT_SIZE_MAIN));
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );

        $data['contriDetails'] = $this->contriModel->where('id', $data['cont'])->first();
        $payUser = array();
		foreach($this->paymentModel->allPaid() as $pay) {
            if($pay['contri_id'] == $data['cont']) {
                $payUser[] = $pay['user_id'];
            }
		}
        $users = $this->userModel->where('status', '1')->findAll();
        foreach($users as $user) {
            if(!in_array($user['id'], $payUser)) {
                $data['notPaid'][] = ucwords(strtolower($user['first_name'])).' '.ucwords(strtolower($user['last_name']));
            }
        }

        $pdf->AddPage();
        $pdf->writeHTML(view('Modules\Reports\Views\reports\notPaidP', $data), true, false, true, false, '');
        $pdf->Ln(4);
        $pdf->Output('List of not paid for the contribution - '.$data['contriDetails']['name'].' - P.pdf', 'I');
    }
}