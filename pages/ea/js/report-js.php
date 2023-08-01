<script>
//datepicker
$(document).ready(function(){
  $('.datepicker').datepicker({
    clearBtn: true,
    format: "MM dd, yyyy",
    setDate: new Date(),
    autoClose: true
  });
  //select 2
  $('.select2').select2();
})

//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}

//clear or reset the dropdown box
$(document).ready(function(){
  $('.remove-data').on('click', function(e){
    e.preventDefault();

    $('#fo-company').append('<option selected disabled>Select a Company</option>');
    $('#fo-supplier').append('<option selected disabled>Select a Supplier</option>');
    $('#fo-status').append('<option selected disabled>Select a Status</option>');
  })
})

//button event handler
//CHECK FOR RELEASING
$('#for-releasing').on('click', function(e){
  e.preventDefault();

  $('#check').show();
  $('#disbursement').hide();
  $('#percentage-report').hide();
  $('#manage-report').hide();
})

//generate management report function
function generate_report()
{
  var company = $('#manage-company').val();
  var supplier = $('#manage-supplier').val();
  var status = $('#manage-status').val();
  var date_from = $('#manage-from').val();
  var date_to = $('#manage-to').val();
  var action = '';

  if(company != 0 && supplier == 0 && status == 0){
    var action = 1;//Generate report by COMPANY & date span
  }else if(company == 0 && supplier != 0 && status == 0){
    var action = 2;//Generate report by SUPPLIER & date span
  }else  if(company == 0 && supplier == 0 && status != 0){
    var action = 3;//Generate report by STATUS & date span
  }else if(company != 0 && supplier != 0 && status == 0){
    var action = 4;//Generate report by COMPANY, SUPPLIER & Date Span
  }else if(company != 0 && supplier != 0 && status != 0){
    var action = 5;//Generate report by ALL 
  }else if(company != 0 && supplier != 0 && status == 0){
    var action = 6;//Generate report by COMPANY, SUPPLIER & DATE SPAN
  }else if(company != 0 && supplier == 0 && status != 0){
    var action = 7;//Generate report by COMPANY, STATUS & DATE SPAN 
  }else if(company != 0 && supplier != 0 && status != 0){
    var action = 8;//Generate report by SUPPLIER, STATUS & DATE SPAN 
  }else{
    var action = 9;//Generate report by DATE SPAN only
  }
  
  var myData = 'company=' + company + '&supplier=' + supplier + '&status=' + status + '&date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;

  if(date_from == '' && date_to == ''){
    toastr.error('ERROR! Please select a date span to generate report.');
    $('#from').focus();
  }else{
    showToast();
    window.open('../../controls/generate_report_ea.php?' + myData);
  }   
}
</script>