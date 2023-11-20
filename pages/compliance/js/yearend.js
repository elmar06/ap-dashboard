$(document).ready(function(){
  $('.DataTable').dataTable({
      scrollX: true
  })
})

//received Request
$('.btnReceive').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
  var action = 1;
  $.ajax({
    type: 'POST',
    url: '../../controls/process_yearend.php',
    data: {id:id, action:action},
    success: function(response){
      if(response > 0){
        toastr.success('Request successfully received.');
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
      }
    }
  }) 
})

//returned request
$('.btnReturn').on('click', function(e){
  e.preventDefault();

  var id = $(this).val();
  var action = 2;
  $.ajax({
    type: 'POST',
    url: '../../controls/process_yearend.php',
    data: {id:id, action:action},
    success: function(response){
      if(response > 0){
        toastr.success('Request successfully mark as returned.');
        setTimeout(function(){
          location.reload();
        }, 1500)
      }else{
        toastr.error('ERROR! Please contact the system administrator at local 124 for assistance');
      }
    }
  }) 
})