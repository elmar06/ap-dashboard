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
//DISBURSEMENT REPORT
$('#report').on('click', function(e){
  e.preventDefault();

  $('#disbursement').show();
  $('#check').hide();
  $('#percentage-report').hide();
  $('#manage-report').hide();
})
//PERCENTAGE REPORT
$('#percentage').on('click', function(e){
  e.preventDefault();

  $('#disbursement').hide();
  $('#check').hide();
  $('#percentage-report').show();
  $('#manage-report').hide();
})
//MANAGEMENT REPORT
$('#management-report').on('click', function(e){
  e.preventDefault();

  $('#disbursement').hide();
  $('#check').hide();
  $('#percentage-report').hide();
  $('#manage-report').show();
})

//generate report function
function for_releasing_report()
{
  var project = $('#fo-project').val();
  var company = $('#fo-company').val();
  var supplier = $('#fo-supplier').val();
  var date_from = $('#from').val();
  var date_to = $('#to').val();
  var action = 1;
  //initialize action
  if(project != 0 && company == 0 && supplier == 0){
    var rep_action = 1;//Generate report by PROJECT & date span
  }else if(project == 0 && company != 0 && supplier == 0){
    var rep_action = 2;//Generate report by COMPANY & date span
  }else  if(project == 0 && company == 0 && supplier != 0){
    var rep_action = 3;//Generate report by SUPPLIER & date span
  }else if(project != 0 && company != 0 && supplier == 0){
    var rep_action = 4;//Generate report by PROJECT, COMPANY & Date Span
  }else if(project != 0 && company != 0 && supplier != 0){
    var rep_action = 5//Generate report by ALL
  }else if(project == 0 && company != 0 && supplier != 0){
    var rep_action = 6;//Generate report by COMPANY, SUPPLIER & DATE SPAN
  }else{
    var rep_action = 7;//Generate report by DATE SPAN only
  }

  var myData = 'project=' + project + '&company=' + company + '&supplier=' + supplier + '&date_from=' + date_from + '&date_to=' + date_to + '&action=' + action + '&rep_action=' + rep_action;

  if(date_from == '' && date_to == ''){
    toastr.error('ERROR! Please select a date span to generate report.');
    $('#from').focus();
  }else{
    showToast();
    window.open('../../controls/generate_report_fo.php?' + myData);
  }   
}
//generate report function
function disbursement_report()
{
  var date_from = $('#dis-from').val();
  var date_to = $('#dis-to').val();
  var action = 2;
  var myData = 'date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;
  showToast();
  window.location = '../../controls/generate_report_fo.php?' + myData;
}
//generate report function
function percentage_report()
{
  var date_from = $('#percent-from').val();
  var date_to = $('#percent-to').val();
  var action = 3;
  var myData = 'date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;
  showToast();
  window.location = '../../controls/generate_report_fo.php?' + myData;
}
//generate management report function
function generate_report()
{
  var project = $('#manage-project').val();
  var company = $('#manage-company').val();
  var supplier = $('#manage-supplier').val();
  var status = $('#manage-status').val();
  var date_from = $('#manage-from').val();
  var date_to = $('#manage-to').val();
  var action = '';

  if(project != 0 && company == 0 && supplier == 0 && status == 0){
    var action = 1;//Generate report by PROJECT & date span
  }else if(project == 0 && company != 0 && supplier == 0 && status == 0){
    var action = 2;//Generate report by COMPANY & date span
  }else  if(project == 0 && company == 0 && supplier != 0 && status == 0){
    var action = 3;//Generate report by SUPPLIER & date span
  }else  if(project == 0 && company == 0 && supplier == 0 && status != 0){
    var action = 4;//Generate report by STATUS & date span
  }else if(project != 0 && company != 0 && supplier == 0 && status == 0){
    var action = 5;//Generate report by PROJECT, COMPANY & Date Span
  }else if(project != 0 && company != 0 && supplier != 0 && status == 0){
    var action = 6;//Generate report by PROJECT, COMPANY, SUPPLIER & Date Span
  }else if(project != 0 && company != 0 && supplier != 0 && status != 0){
    var action = 7;//Generate report by ALL 
  }else if(project != 0 && company == 0 && supplier != 0 && status == 0){
    var action = 9;//Generate report by PROJECT, SUPPLIER & DATE SPAN
  }else if(project != 0 && company == 0 && supplier == 0 && status != 0){
    var action = 10;//Generate report by PROJECT, STATUS & DATE SPAN
  }else if(project == 0 && company != 0 && supplier != 0 && status == 0){
    var action = 11;//Generate report by COMPANY, SUPPLIER & DATE SPAN
  }else if(project == 0 && company != 0 && supplier == 0 && status != 0){
    var action = 12;//Generate report by COMPANY, STATUS & DATE SPAN
  }else if(project == 0 && company == 0 && supplier != 0 && status != 0){
    var action = 13;//Generate report by SUPPLIER, STATUS & DATE SPAN
  }else if(project != 0 && company == 0 && supplier != 0 && status != 0){
    var action = 14;//Generate report by PROJECT, SUPPLIER, STATUS & DATE SPAN
  }else if(project != 0 && company != 0 && supplier == 0 && status != 0){
    var action = 15;//Generate report by PROJECT, COMPANY, STATUS & DATE SPAN
  }else{
    var action = 8;//Generate report by DATE SPAN only
  }

  var myData = 'project=' + project + '&company=' + company + '&supplier=' + supplier + '&status=' + status + '&date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;

  if(date_from == '' && date_to == ''){
    toastr.error('ERROR! Please select a date span to generate report.');
    $('#from').focus();
  }else{
    showToast();
    window.open('../../controls/generate_report_manager.php?' + myData);
  }   
}
</script>