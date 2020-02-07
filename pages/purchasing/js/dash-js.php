<!-- search box in drop down menu -->
<script>
    $(".select2").select2();
</script>

<!-- toast -->
<script>
  function showToast(){
    var title = 'Loading...';
    var duration = 500;
    $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
  }
  function hideLoading(){
    $.Toast.hideToast();
  }

//datepicker
$('.datepicker').datepicker({
  clearBtn: true,
  format: "MM dd, yyyy",
  setDate: new Date(),
  autoClose: true
});

//details 
$('.details').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  $.ajax({
    type: 'POST',
    url: '../../controls/view_po_details_byID.php',
    data: {id: id},
    beforeSend: function()
    {
      showToast();
    },
    success: function(html)
    {
      $('#POmodalDetails').modal('show');
      $('#details-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

//Edit button
function EnableFields()
{
  $('#upd-bill-date').attr('disabled', false);
  $('#upd-bill-no').attr('disabled', false);
  $('#upd-po-no').attr('disabled', false);
  $('#upd-company').attr('disabled', false);
  $('#upd-supplier').attr('disabled', false);
  $('#upd-terms').attr('disabled', false);
  $('#btnEdit').attr('disabled', true);
  $('#btnClose').hide();
  $('#btnCancel').show();
  $('#btnSubmit').attr('disabled', false);
}

//Cancel button
function DisableFields()
{
  $('#upd-bill-date').attr('disabled', true);
  $('#upd-bill-no').attr('disabled', true);
  $('#upd-po-no').attr('disabled', true);
  $('#upd-company').attr('disabled', true);
  $('#upd-supplier').attr('disabled', true);
  $('#upd-terms').atrr('disabled', true);
  $('#btnEdit').attr('disabled', false);
  $('#btnClose').show();
  $('#btnCancel').hide();
  $('#btnSubmit').attr('disabled', true);
}

//submit
function SubmitPO()
{
  var bill_date = $('#bill-date').val();
  var terms = $('#terms').val();
  var due_date = $('#due-date').val();
  var days_due = $('#days-due').val();
  var bill_no = $('#bill-no').val();
  var po_num = $('#po-no').val();
  var company = $('#company').val();
  var supplier = $('#supplier').val();
  var myData = 'bill_date=' + bill_date + '&terms=' + terms + '&due_date=' + due_date + '&days_due=' + days_due + '&bill_no=' + bill_no + '&po_num=' + po_num + '&company=' + company + '&supplier=' + supplier;
  
  if(bill_date != null && bill_no != '' && po_num != '' && company != null && supplier != null)
  {
    $.ajax({
        type: 'POST',
        url: '../../controls/add_po.php',
        data: myData,
        beforeSend: function()
        {
          showToast();
        },
        success: function(response)
        {
          if(response > 0)
          {
            $('#add-success').html('<center><i class="fas fa-check"></i> PO/JO Successfully submitted.</center>');
            $('#add-success').fadeIn();
            setTimeout(function(){
                $('#add-success').fadeOut(5000);
            })
            //get the updated list
            $.ajax({
              url: '../../controls/view_submit_po.php',
              success: function(html)
              {
                $('#po-details-body').fadeOut();
                $('#po-details-body').fadeIn();
                $('#po-details-body').html(html);

              }
            })
          }
          else
          {
            $('#add-warning').html('<center><i class="fas fa-ban"></i> Adding Failed. Please call the IT administrator in local 124 for assistance.</center>');
            $('#add-warning').show();
            setTimeout(function(){
                $('#add-warning').hide();
            }, 5000)
          }
        },
        error: function(xhr, ajaxOptions, thrownError)
        {
          alert(thrownError);
        }
    })
  }else{
    $('#add-warning').html('<center><i class="fas fa-ban"></i> Submit Failed. Please input all the data needed.</center>');
    $('#add-warning').show();
    setTimeout(function(){
        $('#add-warning').fadeOut();
    }, 5000)
  }
}

//update
function upd_po_details()
{
  var id = $('#upd-po-id').val();
  var bill_date = $('#upd-bill-date').val();
  var terms = $('#upd-terms').val();
  var due_date = $('#upd-due-date').val();
  var days_due = $('#upd-days-due').val();
  var bill_no = $('#upd-bill-no').val();
  var po_num = $('#upd-po-no').val();
  var company = $('#upd-company').val();
  var supplier = $('#upd-supplier').val();
  var myData = 'id=' + id + '&bill_date=' + bill_date + '&terms=' + terms + '&due_date=' + due_date + '&days_due=' + days_due + '&bill_no=' + bill_no + '&po_num=' + po_num + '&company=' + company + '&supplier=' + supplier;

  if(bill_date != null && bill_no != '' && po_num != '')
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/upd_po_details.php',
      data: myData,
      beforeSend: function()
      {
        showToast();
      },
      success: function(response)
      {
        if(response > 0)
        {
          $('#upd-success').html('<center><i class="fas fa-check"></i> Update Successful.</center>');
          $('#upd-success').show();
          setTimeout(function(){
            $('#upd-success').fadeOut();
          }, 3000)
          //get the updated list
          $.ajax({
              url: '../../controls/view_submit_po.php',
              success: function(html)
              {
                $('#po-details-body').fadeOut();
                $('#po-details-body').fadeIn();
                $('#po-details-body').html(html);
              }
            })
        }
        else
        {
          $('#upd-warning').html('<center><i class="fas fa-ban"></i> Update Failed. Please contact the Administrator at local 124.</center>');
          $('#upd-warning').show();
          setTimeout(function(){
              $('#upd-warning').fadeOut();
          }, 5000)
        }
      }
    })
  }
  else
  {
    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Submit Failed. Please input all the data needed.</center>');
    $('#upd-warning').show();
    setTimeout(function(){
      $('#upd-warning').fadeOut();
    }, 5000)
  }
}

//set date format
function formatDate(date){
  var monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  var d = new Date(date),
      month = d.getMonth(),
      day = d.getDate(),
      year = d.getFullYear();

  if(month.length < 2)
    month = '0' + month;
  if(day.length < 2)
    day = '0' + day;
  //return [year, month, day].join('-');
  return monthName[month] + ' ' + day + ', ' + year;
}

//format date for calculation
function formatDateCal(date){
  var d = new Date(date),
      month = d.getMonth() + 1,
      day = d.getDate(),
      year = d.getFullYear();

  if(month.length < 2)
    month = '0' + month;
  if(day.length < 2)
    day = '0' + day;
  return [year, month, day];
}

//add days base on term
Date.prototype.addDays = function(days){
  this.setDate(this.getDate() + parseInt(days));
  return this;
}

//get the due date of PO
function getDueDate()
{ 
  var date = $('#bill-date').val();
  var terms = $('#terms').val();

  if(terms != '' && date != null)
  {
    var bill_date = new Date(date);//get the bill date
    var due_date = bill_date.addDays(terms);//add the terms to get the due date
    var due = formatDate(due_date);// date format
    $('#due-date').val(due);//display the date

    //get the due days 
    var oneDay = 24 * 60 * 60 * 1000;
    var from = $('#bill-date').val();
    var to = $('#due-date').val();

    var billDate = new Date(formatDateCal(from));
    var DueDays = new Date(formatDateCal(to));
    var time = Math.abs(billDate - DueDays);
    var days = Math.ceil(time / (oneDay));
    $('#days-due').val(days);//display the days left
  }else{
    $('#due-date').val('PO Due Date');
    $('#days-due').val('No. of Days');
  }
}
</script>