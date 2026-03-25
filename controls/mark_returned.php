<?php
include '../config/clsConnection.php';
include '../config/clsConnectionRCP.php';
include '../config/clsConnectionMain.php';
include '../objects/clsPODetails.php';
include '../objects/clsRCPDetails.php';
include '../objects/clsMain.php';

require '../phpmailer/class.phpmailer.php';
require '../phpmailer/class.smtp.php';

$database = new clsConnection();
$db = $database->connect();

$databaseRCP = new clsConnectionRCP();
$dbRCP = $databaseRCP->connectRCP();

$databaseMain = new clsConnectionMain();
$dbMain = $databaseMain->connectMain();

$po = new PO_Details($db);
$rcp = new RCP_Details($dbRCP);
$main = new clsMain($dbMain);

if($_POST['remarks'] != null || $_POST['remarks'] != '')
{
    $remarks = $_POST['remarks'];
}else{
    $remarks = null;
}

//po details
$po->status = 2;
$po->id = $_POST['id'];
//other details
$po->date_returned_req = date('Y-m-d');
$po->remarks = $remarks;
$po->po_id = $_POST['id'];

$mark = $po->mark_as_returned();
$update = $po->upd_date_returned();

//check if rcp_id is not empty7401;
$po->id = 7401;//$_POST['id'];
$get = $po->get_po_by_id();
while($row = $get->fetch(PDO::FETCH_ASSOC)){
    //mark returned in rcp db
    $rcp->id = $row['rcp_id'];
    $rcp->ap_remark = $_POST['remarks'];
    $return = $rcp->mark_returned_RCP();
    if($return){
        $rcp_no = '';
        $payee_name = '';
        $currency = '';
        $total = '';
        $submit_by = '';
        $firstname = '';
        $fullname = '';
        $email = '';
        //get the RCP details
        $rcp->id = $row['rcp_id'];
        $data = $rcp->get_rcp_details();
        while($rowRCP = $data->fetch(PDO::FETCH_ASSOC)){
            $rcp_no = $rowRCP['rcp_no'];
            $payee = $rowRCP['payee'];
            $total = $rowRCP['total'];
            $submit_by = $rowRCP['submit_by'];
            //get the currency type
            $get = $main->view_all_currency();
            while ($rowCur = $get->fetch(PDO::FETCH_ASSOC)) {
                if($rowRCP['currency'] == $rowCur['id']){
                    $currency = $rowCur['type'];
                }else{
                    $currency = 'PHP';
                }
            }
        }
        //get the user details
        $main->id = $submit_by;
        $dataUser = $main->get_user_details();
        while($rowUser = $dataUser->fetch(PDO::FETCH_ASSOC)){
            $firstname = $rowUser['firstname'];
            $fullname = $rowUser['firstname'].' '.$rowUser['lastname'];
            $email = $rowUser['email'];
        }
        //get the payee details
        $main->id = $submit_by;
        $dataPayee = $main->get_supplier_details();
        while($rowPayee = $dataPayee->fetch(PDO::FETCH_ASSOC)){
            $payee_name = $rowPayee['supplier_name'];
        }
        //send an email notificaion to the RCP requester
        $email_app = $rowUser['email'];
        $fullname = $rowUser['firstname'].' '.$rowUser['lastname'];
        
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'it.cebu6000@gmail.com';
        $mail->Password = 'mjpwnweozvzfhqvm';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('it.cebu6000@gmail.com', 'Online RCP');
        $mail->addAddress($email, $fullname); //Recipient name

        $mail->isHTML(true);
        $mail->Subject = "Online RCP Notification";
        $message = "<html>
                        <head>
                        </head>
                            <body style='margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri'>
                                <div style='background-color: #1a7bb9; padding: 5px; color: white'>
                                    <h3 style='padding: 0; margin: 0;'>Notice: Online RCP Notification</h3>
                                </div>
                                <div style='border: 1px solid #e1e1e1; padding: 5px'>    
                                    Hi ".$firstname.", <br><br>
                                    This is to inform you that your RCP with the following details has been marked as Returned by Accounting:<br><br>
                                    RCP Number: <b>".$rcp_no."</b><br>
                                    Payee: <b>".$payee_name."</b><br>
                                    Amount: <b>".$currency." ".$total."</b><br>
                                    Reason: ".$_POST['remarks']."<br><br> 
                                    Thank you. <br>System Administrator
                                </div>
                                <br/>
                                <br/>
                                <div style='padding:10px 0px; text-align: center; font-size: 11px; border-top: 1px solid #e1e1e1'>
                                    IGC Online RCP System &middot; <a href='http://www.innogroup.com.ph'>Innogroup</a>
                                </div>
                        </body>
                    </html>";
        $mail->Body = $message;
        echo ($mail->send()) ? 1 : 0;
    }else{
        echo 0;
    }
}
// mark the entry in AP Dashboard as returned
if($mark){
    if($update){
        echo 2;
    }else{
        echo 0;
    }
}else{
    echo 0;
}
?>