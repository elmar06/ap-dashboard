<?php
include '../config/clsConnection.php';
include '../objects/clsPODetails.php';
include '../objects/clsSupplier.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$po = new PO_Details($db);
$company = new Company($db);
$supplier = new Supplier($db);

$po->id = $_POST['id'];
$get = $po->get_po_by_id();

while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    $bill_date = date('F d, yy', strtotime($row['bill_date']));
    $due_date = date('F d, yy', strtotime($row['due_date']));
    echo '
    <div class="row">
        <div class="col-lg-8">
        <input id="upd-po-id" class="form-control mb-3" type="text" value="'.$row['po-id'].'" hidden>
        <label>Billing/Invoice Date:</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-bill-date" class="form-control datepicker" placeholder="Enter Billing Date" value="'.$bill_date.'" disabled>
        </div>
        </div>
        <div class="col-lg-4">
        <label>Terms:</label>
        <input id="upd-terms" class="form-control mb-3" type="text" placeholder="Enter Terms" value="'.$row['terms'].'" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
        <label>Due Date:</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
            </div>
            <input id="upd-due-date" class="form-control datepicker" placeholder="PO Due Date" value="'.$due_date.'" disabled>
        </div>
        </div>
        <div class="col-lg-4">
        <label>Days before Due</label>
        <input id="upd-days-due" class="form-control mb-3" type="text" placeholder="No. of Days" value="'.$row['days_due'].'" disabled>
        </div>
    </div><br>
    <div class="row">
        <div class="col-lg-12">
        <label><b><i>General Information</i></b></label>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
        <label>Invoice/Billing No:</label>
        <input id="upd-bill-no" class="form-control mb-3" type="text" placeholder="Enter Billing number" value="'.$row['bill_no'].'" disabled>
        </div>
        <div class="col-lg-6">
        <label>PO/JO Number:</label>
        <input id="upd-po-no" class="form-control mb-3" type="text" placeholder="Enter PO/JO number" value="'.$row['po_num'].'" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
        <label>Company:</label>
        <select id="upd-company" class="form-control mb-3 select2" style="width: 100%;" disabled>
            <option selected disabled>Please select a Company</option>';
            $get = $company->get_active_company();
            while($row1 = $get->fetch(PDO::FETCH_ASSOC))
            {
                if($row['comp-id'] = $row1['id'])
                {
                    echo '<option value="'.$row1['id'].'" selected>'.$row1['company'].'</option>';
                }else{
                    echo '<option value="'.$row['id'].'">'.$row['company'].'</option>';
                }
            }
        echo '</select>
        </div>
        <div class="col-lg-6">
        <label>Supplier:</label>
        <select id="upd-supplier" class="form-control mb-3 select2"  style="width: 100%;" disabled>
            <option selected disabled>Please select a Supplier</option>';
            $get = $supplier->get_active_supplier();
            while($row2 = $get->fetch(PDO::FETCH_ASSOC))
            {
                if($row['supp-id'] = $row2['id'])
                {
                    echo '<option value="'.$row2['id'].'" selected>'.$row2['supplier_name'].'</option>';
                }else{
                    echo '<option value="'.$row2['id'].'">'.$row2['supplier_name'].'</option>';
                }
            }
        echo '</select>
        </div>
    </div><br>
    <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
    <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div> ';
}
?>

<script>
    $(".select2").select2();
    
    //datepicker
    $('.datepicker').datepicker({
    clearBtn: true,
    format: "MM dd, yyyy",
    setDate: new Date(),
    autoClose: true
    });
</script>