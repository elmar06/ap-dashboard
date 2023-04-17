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

//clear or reset the dropdown box
$(document).ready(function(){
  $('.remove').on('click', function(e){
    e.preventDefault();

    $('#project').append('<option selected value="0">Select a Project</option>');
    $('#company').append('<option selected value="0">Select a Company</option>');
    $('#supplier').append('<option selected value="0">Select a Supplier</option>');
    $('#status').append('<option selected value="0">Select a Status</option>');
  })
})
</script>