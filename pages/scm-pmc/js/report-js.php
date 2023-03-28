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
function generate_report_scm()
{
  var date_from = $('#dis-from').val();
  var date_to = $('#dis-to').val();
  var action = 1;

  var myData = 'date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;

  if(date_from == '' && date_to == ''){
    toastr.error('ERROR! Please select a date span to generate report.');
    $('#dis-from').focus();
  }else{
    showToast();
    window.open('../../controls/generate_report_scm.php?' + myData);
  }   
}

//generate report function
function generate_report_pmc()
{
  var project = $('#project').val();
  var company = $('#company').val();
  var supplier = $('#supplier').val();
  var status = $('#status').val();
  var date_from = $('#from').val();
  var date_to = $('#to').val();
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
  }else{
    var action = 8;//Generate report by DATE SPAN only
  }
  
  var myData = 'project=' + project + '&company=' + company + '&supplier=' + supplier + '&status=' + status + '&date_from=' + date_from + '&date_to=' + date_to + '&action=' + action;

  if(date_from == '' && date_to == ''){
    toastr.error('ERROR! Please select a date span to generate report.');
    $('#from').focus();
  }else{
    showToast();
    window.open('../../controls/generate_report_pmc.php?' + myData);
  }   
}

//clear or reset the dropdown box
$(document).ready(function(){
  $('.remove-data').on('click', function(e){
    e.preventDefault();

    $('#project').append('<option selected disabled>Select a Project</option>');
    $('#company').append('<option selected disabled>Select a Company</option>');
    $('#supplier').append('<option selected disabled>Select a Supplier</option>');
    $('#status').append('<option selected disabled>Select a Status</option>');
    //enable fields
    $('#project').attr('disabled', false);
    $('#company').attr('disabled', false);
    $('#supplier').attr('disabled', false);
    $('#status').attr('disabled', false);
  })
})
</script>