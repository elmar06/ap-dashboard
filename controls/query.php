<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsCheckDetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$check = new CheckDetails($db);
$supplier = new Supplier($db);
$user = new Users($db);

//get all the staled check
$get = $check->get_all_check_details();
while($row = $get->fetch(PDO:: FETCH_ASSOC))
{
   //check all the processed po by BO with checked
   $date_now = new DateTime(date('Y-m-d'));
   $check_date = new DateTime(date('Y-m-d', strtotime($row['check_date'])));
   //po_details id
   $id = $row['po_id'];
   $array_id = explode(',', $id);
   foreach($array_id as $value)
   {
      //calculate the date difference
      $no_days = $date_now->diff($check_date)->days;
      if($no_days >= 170){
         //update the check status and set into stale
         $check->po_id = $value; 
         $check->stale_date = date('Y-m-d');
         $upd_check = $check->mark_as_stale_check();
         //change the status into FOR CV CREATION (status = 20)
         $po->id = $value;
         $upd_PODetails = $po->mark_stale();
         //clear-up some data in po_other_details
         $po->po_id = $value;
         $upd = $po->clear_details_stale();
         //get details for email notification
         $email = ''; 
         //get the email  address of the BO users
         $get_email = $user->get_bo_staff();
         while($rowUser = $get_email->fetch(PDO:: FETCH_ASSOC))
         {
            $email = $rowUser['email'];
            //system notification to all Back office users
            $from = "system.administrator<(noreply@innogroup.com.ph)>"; 
            $to = $email;

            $subject = "AP Dashboard Stale Check Details";
            $message = "<html>
                           <body style='margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri'>
                                 <div style='background-color: #e38202; padding: 5px; color: white'>
                                    <h3 style='padding: 0; margin: 0;'>Notice: </h3>
                                 </div>
                                 <div style='border: 1px solid #e1e1e1; padding: 5px'>    
                                    Hi, <br><br>Greetings!<br><br>
                                    Please refer below for the stale check details.
                                    <br><br>
                                    <b>CV No.: ".$row['cv_no']."</b><br>
                                    <b>Check No.: ".$row['check_no']."</b><br>
                                    <b>Check Date: ".date('F j, Y', strtotime($row['check_date']))."</b><br>
                                    <br><br>
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
?>