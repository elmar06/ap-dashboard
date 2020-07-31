<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsUser.php';
include '../objects/clsAccess.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$user = new Users($db);
$access = new Access($db);

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

//check if dept is null
// $department = $_POST['department'] ;
// if($department== null)
// {
//     $department = 0;
// }
//get the Manila time by timezone
date_default_timezone_set('Asia/Manila');
//covert the date format for db
$bill_date = date('Y-m-d', strtotime($_POST['bill_date']));
$due_date = date('Y-m-d', strtotime($_POST['due_date']));
//remove the currency format
$fmt = new NumberFormatter( 'en_US', NumberFormatter::DECIMAL );
$num = $_POST['amount'];
$amount = $fmt->parse($num);

//save details to po_details table
$po->bill_no = $_POST['bill_no'];
$po->po_num = $_POST['po_num'];
$po->company = $_POST['company'];
$po->supplier = $_POST['supplier'];
$po->project = $_POST['project'];
$po->department =$_POST['department'];
$po->bill_date = $bill_date;
$po->terms = $_POST['terms'];
$po->due_date = $due_date;
$po->days_due = null;
$po->amount = $amount;
$po->date_submit = date('Y-m-d');
$po->reports = $_POST['reports'];
$po->si_num = $_POST['si_num'];
$po->submitted_by = $_POST['submitted_by'];

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
                            $from = "system.administrator<(noreply@innogroup.com.ph)>"; 
                            $to = $email;
                            $staff = $firstname;

                            $subject = "AP Dashboard Request Notification";
                            $message = "<html>
                                            <body style='margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri'>
                                                <div style='background-color: #00C957; padding: 5px; color: white'>
                                                    <h3 style='padding: 0; margin: 0;'>Notice: </h3>
                                                </div>
                                                <div style='border: 1px solid #e1e1e1; padding: 5px'>    
                                                    Hi ".$staff.", <br><br>Greetings!<br><br>
                                                    You have a new request from purchasing department.<br><br>
                                                    Thank you. <br><br> Best Regards, <br>System Administrator
                                                </div>
                                                <br/>
                                                <br/>
                                            </body>
                                        </html>";

                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                            $headers .= "From: ".$from."" . "\r\n" ;

                            if(mail($to,$subject,$message,$headers))
                            {
                                echo 1;
                            }
                            else
                            {
                                echo 0;
                            }
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