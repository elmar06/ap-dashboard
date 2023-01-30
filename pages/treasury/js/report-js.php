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
  var date_from = $('#from').val();
  var date_to = $('#to').val();
  //action validation
  if(company != null && supplier == null){
    var action = 1;//generate company with date span
  }else if(supplier != null && company == null){
    var action = 2;//generate supplier with date span
  }else if(supplier != null && company != null){
    var action = 3;//generate by supplier, company & date span
  }else{
    var action = 4;//generate by date span only
  }
  var myData = 'company=' + company + '&supplier=' + supplier + '&date_from=' + date_from + '&date_to=' + date_to + '&action=' + action; 

  if(company == null && supplier == null && date_from == '' && date_to == '')
  {
    toastr.error('ERROR! Please input data for report generation.');
  }
  else
  {
    //send data to report page
    window.location = '../../controls/generate_report_treasury.php?' + myData; 
  }
}
</script>