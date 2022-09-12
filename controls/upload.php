<?php
session_start();
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$filename = $_FILES['files']['tmp_name'];
if($_FILES['files']['size'] > 0)
{
	$file = fopen($filename, "r");
	$count = 0;

	while(($data = fgetcsv($file, 10000, ",")) !== FALSE)
	{
		$count ++;
		if($count > 1)
		{
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
            //po_details table
            $po->bill_no = $data[0];
            $po->po_num = $data[1];
            $po->amount = $data[2];
            $po->si_num = $data[3];
            $po->company = $data[4];
            $po->supplier = $data[5];
            $po->project = $data[6];
            $po->department = $data[7];
            $po->bill_date = $data[8];
            $po->terms = $data[9];
            $po->due_date = $data[10];
            $po->date_submit = date('Y-m-d');
            $po->submitted_by = $_SESSION['id'];

			$save = $po->upload_po();
            //save other details
            $po->po_id = $id;
            $details = $po->upload_other_details();   

			if($save)
			{
                if($details)
			    {
				    echo 1;
                }
                else
                {
                    echo 0;
                }
			}
			else
			{
				echo 0;
			}
		}
	}
}
else
{
	echo 0;
}

?>