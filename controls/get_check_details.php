<?php
include '../config/clsConnection.php';
include '../objects/clsCheckDetails.php';
include '../objects/clsPODetails.php';
include '../objects/clsBank.php';

$database = new clsConnection();
$db = $database->connect();

$check = new CheckDetails($db);
$po = new PO_Details($db);
$bank = new Banks($db);

$check->po_id = $_POST['id'];
$get = $check->get_details();

while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    //check if the OR/CR is not null
    $po_id = explode(',', $_POST['id']);
    foreach($po_id as $value)
    {
        $po->id = $value;
        $get_or = $po->get_or_num();
        while($rowOR = $get_or->fetch(PDO:: FETCH_ASSOC))
        {
            if($rowOR['receipt'] == null || $rowOR['receipt'] == ''){
                $receipt = '<input id="receipt-no" class="form-control mb-3" type="text" placeholder="Input Receipt number">';
            }else{
                $receipt = '<input id="receipt-no" class="form-control mb-3" type="text" value="'.$rowOR['receipt'].'" disabled>';
            }
        }
    }
    //format the date for display
    $check_date = date('F d, Y', strtotime($row['check_date']));
    echo '<small><b><i>Check Information</i></b></small>
    <div class="row">
        <div class="col-lg-6">
            <label>CV Number:</label>
            <input class="form-control mb-3" type="text" placeholder="Enter CV Number" value="'.$row['cv_no'].'" disabled>
            <input id="po-id" class="form-control mb-3" type="text" placeholder="Enter CV Number" value="'.$row['po_id'].'" hidden>
        </div>
        <div class="col-lg-6">
            <label>Check Number:</label>
            <input class="form-control mb-3" type="text" placeholder="Enter Check Number" value="'.$row['check_no'].'" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label>Bank:</label>
            <select class="form-control mb-3 select2" style="width: 100%;" disabled>
                <option selected disabled>Select a Bank</option>';
                $get = $bank->get_all_banks();
                while($row2 = $get->fetch(PDO::FETCH_ASSOC))
                {
                    if($row['bank'] == $row2['id'])
                    {
                        echo '<option value="'.$row2['id'].'" selected>'.$row2['account'].'</option>';
                    }else{
                        echo '<option value="'.$row2['id'].'">'.$row2['name'].'</option>';
                    }
                }
            echo '</select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label>Release Date:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input id="release-date" class="form-control datepicker" placeholder="Enter Release Date">
            </div>
        </div>
        <div class="col-lg-6">
            <label>Billing/Invoice Date:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                </div>
                <input class="form-control datepicker" placeholder="Enter Check Date" value="'.$check_date.'" disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <label><i style="color: red">*</i> OR/CR Number:</label>
            <input id="or-num" class="form-control mb-3" type="text" placeholder="Enter OR/CR Number">
        </div>
        <div class="col-lg-6">
            <label> Probitionary Receipt:</label>
            '.$receipt.'
        </div>
    </div>
    <div id="success" class="alert alert-success" role="alert" style="display: none"></div>
    <div id="warning" class="alert alert-danger" role="alert" style="display: none"></div>';
}
?>
<script>
//datepicker
$('.datepicker').datepicker({
  clearBtn: true,
  format: "MM dd, yyyy",
  setDate: new Date(),
  autoClose: true
});
</script>