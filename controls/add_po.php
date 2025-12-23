<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsUser.php';
include '../objects/clsAccess.php';
include 'phpmailer/class.phpmailer.php';
include 'phpmailer/class.smtp.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$user = new Users($db);
$access = new Access($db);
$mail = new PHPMailer();

//get the new id
$id = '';
$get = $po->get_po_id();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    $id = $row['po-id'];
    if($id == null || $id == '0'){
        $id = 1;
    }
}
//check memo amount if null
$memo_amount = 0;
if($_POST['memo_amount'] != 0 || $_POST['memo_amount'] != null){
    $memo_amount = str_replace(',', '', $_POST['memo_amount']);
}
//check if it is for Year-End Report
$status = 1;
$yrEnd_stat = 0;
if($_POST['year_end'] == 17){
    $status = 17;
    $yrEnd_stat = 1;
}
//get the Manila time by timezone
date_default_timezone_set('Asia/Manila');
//covert the date format for db
$bill_date = date('Y-m-d', strtotime($_POST['bill_date']));
$due_date = date('Y-m-d', strtotime($_POST['due_date']));
$po_date = date('Y-m-d', strtotime($_POST['po_date']));
//save details to po_details table
$po->po_num = $_POST['po_num'];
$po->ir_rr_no = $_POST['ir_num'];
$po->po_amount = str_replace(',','', $_POST['po_amount']);
$po->po_date = $po_date;
$po->si_num = $_POST['si_num'];
$po->company = $_POST['company'];
$po->project = $_POST['project'];
$po->department =$_POST['department'];
$po->supplier = $_POST['supplier'];
$po->bill_date = $bill_date;
$po->terms = $_POST['terms'];
$po->amount = str_replace(',','', $_POST['amount']);
$po->due_date = $due_date;
$po->days_due = null;
$po->date_submit = date('Y-m-d');
$po->reports = null;
$po->submitted_by = $_SESSION['id'];
$po->remark = $_POST['remark'];
$po->memo_no = $_POST['memo_no'];
$po->memo_amount = $memo_amount;
$po->debit_memo = $_POST['debit_memo'];
$po->yrEnd_stat = $yrEnd_stat;
$po->status = $status;

$save = $po->add_po();

//save other details
$po->po_id = $id;
$details = $po->save_other_details();

if($details)
{
    if($save)
    {
        //get the list of front office staff
        $get = $user->get_fo_staff();
        while($row = $get->fetch(PDO::FETCH_ASSOC))
        {
            //get the access of user per company
            $id = $row['id'];
            $firstname = $row['firstname'];
            $fullname = $row['firstname'].' '.$row['lastname'];
            $email = $row['email'];
            $array_id = explode(',', $id);
            foreach($array_id as $value)
            {
                $user_id = $value;
                $access->user_id = $user_id;
                $view = $access->get_company();
                while($row1 = $view->fetch(PDO::FETCH_ASSOC))
                {
                    //check if fo staff have the access of company
                    $comp = $row1['comp-access'];
                    $array_comp = explode(',', $comp);
                    foreach($array_comp as $value)
                    {
                        if($_POST['company'] == $value){
                            //sent email to fo staff
                            $staff = $firstname;
                            //phpmailer settings
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'it.cebu6000@gmail.com';
                            $mail->Password = 'akytbgtqxphavqbj';
                            $mail->SMTPSecure = 'ssl'; // or try 'tls'
                            $mail->Port = 465;

                            //receiver/recepient settings
                            $mail->setFrom('it.cebu6000@gmail.com', 'AP Dashboard Admin');
                            $mail->addAddress('elmar.malazarte@innogroup.com.ph', $fullname); // Add a recipient

                            $mail->isHTML(true);
                            $mail->Subject = "AP Dashboard Request Notification";

                            $message = "<html>
                                            <body style='margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri'>
                                                <div style='background-color: #00C957; padding: 5px; color: white'>
                                                    <h3 style='padding: 0; margin: 0;'>Notice: </h3>
                                                </div>
                                                <div style='border: 1px solid #e1e1e1; padding: 5px'>    
                                                    Hi ".$staff.", <br><br>Greetings!<br><br>
                                                    You have a new request from purchasing department with the following details below.<br>
                                                    PO Num: <b>".$_POST['po_num']."</b><br>
                                                    SI Num: <b>".$_POST['si_num']."</b><br><br>
                                                    Thank you. <br><br> Best Regards, <br>System Administrator
                                                </div>
                                                <br/>
                                                <br/>
                                            </body>
                                        </html>";
                            $mail->Body = $message;
                            if(!$mail->send()){
                                echo 0;
                            }else{
                                echo 1;
                            }
                        }else{
                            echo 0;//if no staff will match
                        }
                    }
                }
            }
        }
        echo 1;
    }else{
        echo 0;
    }  
}else{
    echo 0;
}
?>