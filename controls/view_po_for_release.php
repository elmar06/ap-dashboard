<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);

$po->id = $_POST['id'];
$get = $po->get_details_for_releasing();

while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    //date format
    $date = date('F d, yy', strtotime($row['check_date']));

    echo'
        <div id="check-details">
            <small><b><i>Check Information</i></b></small>
            <div class="row">
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> CV Number:</label>
                    <input class="form-control mb-3" type="text" value="'.$row['cv_no'].'" disabled>
                </div>
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> Check Number:</label>
                    <input class="form-control mb-3" type="text" value="'.$row['check_no'].'" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label><i style="color: red">*</i> Bank:</label>
                    <input class="form-control mb-3" type="text" value="'.$row['bank-name'].'" disabled>
                </div>
                <div class="col-lg-6">
                <label><i style="color: red">*</i> Check Date:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input class="form-control datepicker" value="'.$date.'" disabled>
                </div>
                </div>
            </div>
        </div>
        <hr> 
        <div class="row">
        <div class="col-lg-6">
            <label>PO/JO Number:</label>
            <input id="upd-po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po_num'].'" disabled>
        </div>
        <div class="col-lg-6">
            <label>Sales Invoice No.</label>
            <input id="upd-sales-invoice" class="form-control mb-3" type="text" placeholder="Sales Invoice here.." value="'.$row['si_num'].'" disabled>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label>Company:</label>
                <input class="form-control mb-3" type="text" value="'.$row['comp-name'].'" disabled>
            </div>
            <div class="col-lg-6">
                <label>Supplier:</label>
                <input class="form-control mb-3" type="text" value="'.$row['supplier_name'].'" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label>Invoice/Billing No:</label>
                <input class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['bill_no'].'" disabled>
            </div>
            <div class="col-lg-6">
                <label>Amount</label>
                <input id="upd-amount" class="form-control mb-3" type="text" placeholder="Amount" value="'.$row['amount'].'" disabled>
            </div>
        </div>   
        <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}
?>