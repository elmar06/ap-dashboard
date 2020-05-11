<?php
include '../../config/clsConnection.php';
include '../../objects/clsSupplier.php';
include '../../objects/clsCompany.php';
include '../../objects/clsUser.php';
include '../../objects/clsReport.php';

$database = new clsConnection();
$db = $database->connect();

$report = new Reports($db);

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include_report.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('AP DASHBOARD Report Generation');
$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
//$pdf->setFooterData(array(0,64,0), array(0,64,128));
//remove the header and footer data
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 8, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

//initialize data
$report_data = '';
$comp_id  = $_GET['company'];
$supplier_id = $_GET['supplier'];
$requestor_id = $_GET['requestor'];
$from = date('Y-m-d', strtotime($_GET['date_from']));
$to = date('Y-m-d', strtotime($_GET['date_to']));

//GENERATE REPORT BY COMPANY, SUPPLIER, DATE
if($from != null && $to != null && $comp_id != null && $supplier_id != null && $requestor_id != null)
{
	$get_data = $report->generate_by_all_req($from, $to, $requestor_id, $comp_id, $supplier_id);
	while($row = $get_data->fetch(PDO::FETCH_ASSOC))
	{
		$po_num = $row['po_num'];
		$check_date = date('m/d/y', strtotime($row['check_date']));
		$cv_num = $row['cv_no'];
		$bank = $row['bank-name'];
		$check_num = $row['check_no'];
		$payee = $row['supplier_name'];
		$bill_date =  date('m/d/y', strtotime($row['bill_date']));
		$date_received =  date('m/d/y', strtotime($row['date_received_bo']));
		$due_date =  date('m/d/y', strtotime($row['due_date']));
		$amount = $row['amount'];
		$title_name = 'COMPANY NAME: '.$row['comp-name'].'<br>SUPPLIER NAME: '.$row['supplier_name'].'<br>DATE SPAN: '.date('M d, Y', strtotime($from)).' - '.date('M d, Y', strtotime($to));

		$report_data .= '
			<tr>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$po_num.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$check_date.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$cv_num.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$bank.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$check_num.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$payee.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$bill_date.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$date_received.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$due_date.'</td>
				<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px">'.$amount.'</td>
			</tr>';
	}
}

// Set some content to print
$html = <<<EOD
<html>
<head>
</head>
<body>
<h2><i>AP DASHBOARD System Report</i></h2><br><br><br>
<h3><b>$title_name</b></h3>
<table width="100%" cellpadding="10" style="border-top-style:2px; border-left-style:2px; border-right-style:2px; border-bottom-style:2px; font-size: 10px">
	<thead>
		<tr>
			<td align="center" style="border-top-style:2px; border-bottom-style:2px"><b>PO No.</b></td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>Check Date</b>	</td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>CV No.</b></td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>Bank</b></td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>Check No.</b></td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>Payee</b></td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>Billing Date</b></td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>Date Received</b></td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>Due Date</b></td>
			<td align="center" style="border-top-style:2px; border-left-style:2px; border-bottom-style:2px"><b>Amount</b></td>
		</tr>
	</thead>
	<tbody>
		$report_data
	</tbody>
</table>	
</body>
</html>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('printReport.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
