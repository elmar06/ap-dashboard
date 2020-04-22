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

//generate report function
function generate_report()
{
  var company = $('#company').val();
  var supplier = $('#supplier').val();
  var requestor = $('#requestor').val();
  var date_from = $('#from').val();
  var date_to = $('#to').val();
  var myData = 'company=' + company + '&supplier=' + supplier + '&requestor=' + requestor + '&date_from=' + date_from + '&date_to=' + date_to;
  //send data to report page
  window.open('../../print/form/printReport.php?' + myData);
}
</script>