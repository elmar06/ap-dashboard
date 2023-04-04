<script>
//datepicker
$('.datepicker').datepicker({
  clearBtn: true,
  format: "MM dd, yyyy",
  setDate: new Date(),
  autoClose: true
});
//select 2
$('.select2').select2();

//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//generate report function
function generate_report()
{
  var company = $('#company').val();
  var supplier = $('#supplier').val();
  var status = $('#status').val();
  var date_from = $('#from').val();
  var date_to = $('#to').val();
  //action validation
  if(company != 0 && supplier == 0 && status == 0){
    var action = 1;//generate company with date span
  }else if(supplier != 0 && company == 0 && status == 0){
    var action = 2;//generate supplier with date span
  }else if(supplier != 0 && company != 0 && status == 0){
    var action = 3;//generate by supplier, company & date span
  }else if(status != 0 && company != 0 && supplier == 0){
    var action = 5;//generate by company, status & date span
  }else if(status != 0 && supplier != 0 && company == 0){
    var action = 6;//generate by supplier, status & date span
  }else if(status != 0 && company != 0 && supplier != 0){
    var action = 7;//generate by company, supplier, status & date span
  }else{
    var action = 4;//generate by date span only
  }
  var myData = 'company=' + company + '&supplier=' + supplier + '&status=' + status + '&date_from=' + date_from + '&date_to=' + date_to + '&action=' + action; 

  if(date_from == '' && date_to == '')
  {
    toastr.error('ERROR! Please select a date span to continue.');
  }
  else
  {
    //send data to report page
    window.location = '../../controls/generate_report_treasury.php?' + myData; 
  }
}

function remove_comp()
{
  alert('heree');
  $('#company')[0].selectedIndex = 0;
  // $('#from').val('');
  // $('#to').val('');
}

function remove_supp()
{
  $('#supplier').prop("selectedIndex", 0);
  $('#from').val('');
  $('#to').val('');
}

function remove_status()
{
  $('#status').prop("selectedIndex", 0);
  $('#from').val('');
  $('#to').val('');
}
</script>