<?php
session_start();

require_once '../config/clsConnection.php';
require_once '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$update_yearEnd_forReceived = new PO_Details($db);
$update_yearEnd_forReceived_date = new PO_Details($db);

// po_details tbl
$update_yearEnd_forReceived->po_id = $_POST['id'];

// po_other_details tbl
$update_yearEnd_forReceived_date->process_by = $_SESSION['id'];
$update_yearEnd_forReceived_date->po_id = $_POST['id'];

$update_forReceived = $update_yearEnd_forReceived->update_yearEnd_forReceived();
$update_forReceived_date = $update_yearEnd_forReceived_date->update_yearEnd_forReceived_date();

if ($update_forReceived && $update_forReceived_date) {
    echo 1;
} else {
    echo 0;
}
