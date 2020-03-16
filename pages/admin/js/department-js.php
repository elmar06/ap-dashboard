<script>
//datatables
$(document).ready(function(){
    $('.dataTable').DataTable();
})

//add company
$('#btnSave').click(function(e){
    e.preventDefault();

    var name = $('#dept-name').val();
    var myData = 'department=' + name; 

    if(name != null)
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/add_department.php',
            data: myData,
            beforeSend: function()
            {
                showToast();
            },
            success: function(response)
            {
                if(response > 0)
                {
                    //display the new list of supplier
                    $.ajax({
                        url: '../../controls/view_all_department.php',
                        success: function(html)
                        {
                            $('#add-success').html('<center><i class="fas fa-check"></i> Department successfully added.</center>');
                            $('#add-success').show();
                            $('#add-success').show();
                            setTimeout(function(){
                                $('#add-success').fadeOut();
                            }, 5000)
                            //fade effect
                            $('#dept-body').html(html);
                            $('#dept-body').fadeOut();
                            $('#dept-body').fadeIn();
                        }
                    })
                }
                else
                {
                    $('#add-warning').html('<center><i class="fas fa-ban"></i> Adding Failed. Please call the IT administrator in local 124 for assistance.</center>');
                    $('#add-warning').show();
                    //hide the message after 3 sec
                    setTimeout(function(){
                        $('#add-warning').fadeOut();
                    }, 5000)
                }
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                alert(thrownError);
            }
        })  
    }
    else
    {
        $('#add-warning').html('<center><i class="fas fa-ban"></i> Department field is empty.</center>');
        //hide the message after 3 sec
        setTimeout(function(){
            $('#add-warning').fadeOut();
        }, 5000)
    }
})

//get the supplier details
$('.btnEdit').click(function(e){
    e.preventDefault();

    var id = $(this).val();
    $.ajax({
        type: 'POST',
        url: '../../controls/view_department_byID.php',
        data: {id: id},
        beforeSend: function()
        {
            showToast();
        },
        success: function(html)
        {
            $('#departmentDetailsModal').modal('show');
            $('#details-body').html(html);
        }
    })
})

//upd supplier
$('#btnUpdDept').click(function(e){
    e.preventDefault();

    var id = $('#upd-id').val();
    var name = $('#upd-name').val();
    var myData = 'id=' + id + '&department=' + name;

    if(name != '')
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/upd_department.php',
            data: myData,
            beforeSend: function()
            {
                showToast();
            },
            success: function(response)
            {
                if(response > 0)
                {
                    //display the new list of supplier
                    $.ajax({
                        url: '../../controls/view_all_department.php',
                        success: function(html)
                        {
                            $('#upd-success').html('<center><i class="fas fa-check"></i> Supplier successfully added.</center>');
                            $('#upd-success').show();
                            setTimeout(function(){
                                $('#upd-success').fadeOut();
                            }, 3000);
                            $('#dept-body').html(html); 
                        }
                    })
                }
                else
                {
                    $('#upd-warning').html('<center><i class="fas fa-ban"></i> Adding Failed. Please call the IT administrator in local 124 for assistance.</center>');
                    $('#upd-warning').show();
                    //hide the message after 3 sec
                    setTimeout(function(){
                        $('#upd-warning').hide();
                    }, 3000)
                }
            }
        })
    }
    else
    {
        $('#upd-warning').html('<center><i class="fas fa-ban"></i> Please input a Supplier Name to proceed.</center>');
        $('#upd-warning').show();
        setTimeout(function(){
            $('#upd-warning').hide();
        }, 3000)
    }
})

//remove supplier
$('.btnRemove').click(function(e){
    e.preventDefault();

    var id = $(this).val();

    $.ajax({
        type: 'POST',
        url: '../../controls/delete_department.php',
        data: {id:id},
        beforeSend: function()
        {
            showToast();
        },
        success: function(response)
        {
            if(response > 0)
            {
                //display the new list of supplier
                $.ajax({
                    url: '../../controls/view_all_department.php',
                    success: function(html)
                    {
                        $('#dept-body').html(html);
                    }
                })
            }
            else
            {
                $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Failed to remove the Department. Please contact the System Administrator at local 124.<i>');
                $('#error-msg').show();
                $('#success-msg').hide();
                $('#errorModal').modal('show');
            }
        }
    })
})

//activate supplier
$('.btnActivate').click(function(e){
    e.preventDefault();

    var id = $(this).val();

    $.ajax({
        type: 'POST',
        url: '../../controls/activate_department.php',
        data: {id:id},
        beforeSend: function()
        {
            showToast();
        },
        success: function(response)
        {
            if(response > 0)
            {
                //display the new list of supplier
                $.ajax({
                    url: '../../controls/view_all_department.php',
                    success: function(html)
                    {
                        $('#dept-body').html(html);
                    }
                })
            }
            else
            {
                $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Failed to Activate the Company. Please contact the System Administrator at local 124.<i>');
                $('#error-msg').show();
                $('#success-msg').hide();
                $('#errorModal').modal('show');
            }
        }
    })
})

//Multi Remove
$("#btnMultiRemove").click(function(){
    if(confirm("Do you really want to deactivate the selected Departments?"))
    {
        var id = []
        $('input:checkbox[name=checklist]:checked').each(function() { //itemid
            id.push($(this).val())
        })
    
        $.each( id, function( key, value ) {
            $.ajax({
                type: "POST",
                data: {id:value},
                url: "../../controls/delete_department.php",
                cache: false,

                success:function(response)
                {
                    if(response > 0)
                    {
                        //display the new list of supplier
                        $.ajax({
                            url: '../../controls/view_all_department.php',
                            success: function(html)
                            {
                                $('#dept-body').html(html);
                                $('.checkboxall').prop('checked', false);
                            }
                        })
                    }
                    else
                    {
                        $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Failed to remove the selected Departments. Please contact the System Administrator at local 124.<i>');
                        $('#error-msg').show();
                        $('#success-msg').hide();
                        $('#errorModal').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError)
                {
                    alert(thrownError);
                }
                });
            });
    }
});
</script>

<!-- CHECKBOXALL-->
<script>
$('.checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value});
      if(selected.length > 1)
      { 
        $('#btnMultiRemove').show();
        $('.btnEdit').prop('disabled',true);
        $('.btnRemove').prop('disabled',true);
        $('.btnActivate').prop('disabled',true);
      }
      else
      {
        $('#btnMultiRemove').hide();
        $('.btnEdit').prop('disabled',false);
        $('.btnRemove').prop('disabled',false);
        $('.btnActivate').prop('disabled',false);
      }
    })
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);

        $('#btnMultiRemove').hide();
        $('.btnEdit').prop('disabled',false);
        $('.btnRemove').prop('disabled',false);
        $('.btnActivate').prop('disabled',false);
    })
  }
})
</script>

<!-- checklist -->
<script>
$('.checklist').change(function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});

  if(selected.length > 1)
  {
        $('#btnMultiRemove').show();
        $('.btnEdit').prop('disabled',true);
        $('.btnRemove').prop('disabled',true);
        $('.btnActivate').prop('disabled',true);
  }
  else
  {
        $('#btnMultiRemove').hide();
        $('.btnEdit').prop('disabled',false);
        $('.btnRemove').prop('disabled',false);
        $('.btnActivate').prop('disabled',false);
  }
})
</script>

<!-- toast function -->
<script>
  function showToast(){
    var title = 'Loading...';
    var duration = 200;
    $.Toast.showToast({title: title,duration: duration, image: '../../assets/img/loading.gif'});
  }
  function hideLoading(){
    $.Toast.hideToast();
  }
</script>