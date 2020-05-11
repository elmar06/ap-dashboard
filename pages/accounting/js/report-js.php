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

//clear or reset the dropdown box
$(document).ready(function(){
  $('.remove-data').on('click', function(e){
    e.preventDefault();

    $('#fo-company').append('<option selected disabled>Select a Company</option>');
    $('#fo-supplier').append('<option selected disabled>Select a Supplier</option>');
  })
})

//generate report function
function generate_report()
{
  var company = $('#fo-company').val();
  var supplier = $('#fo-supplier').val();
  var requestor = $('#user-id').val();
  var date_from = $('#from').val();
  var date_to = $('#to').val();
  var myData = 'company=' + company + '&supplier=' + supplier + '&requestor=' + requestor + '&date_from=' + date_from + '&date_to=' + date_to;
  //send data to report page
  if(date_from != null && date_to != null)
  {
    if(company != null && supplier != null && requestor != null)
    {
      window.open('../../print/form/printReportAll_purchasing.php?' + myData);
    }else{
      window.open('../../print/form/printReport_purchasing.php?' + myData);
    }
  }else{
    window.open('../../print/form/printReport_purchasing.php?' + myData);
  }
}
</script>