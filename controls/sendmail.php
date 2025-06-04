<?php
    $from = "system.administrator<(noreply@innogroup.com.ph)>"; 
    $to = 'elmar.malazarte@innogroup.com.ph';
    $staff = "Rex Labores III";

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
?>