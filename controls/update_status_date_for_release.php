<?php

require_once '../config/clsConnection.php';
require_once '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$select_date = new PO_Details($db);
$update_status = new PO_Details($db);

$select = $select_date->select_date_for_release();

while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
    $po_id = $row['po_id'];

    $update_status->po_id = $po_id;
    $update = $update_status->update_po_status();
}

echo ($update) ? 1 : 0;
