<script>
//datatables
$(document).ready(function(){
    $('.dataTable').dataTable();
})

//add company
$('#btnSave').click(function(e){
    e.preventDefault();

    var name = $('#company-name').val();
    var myData = 'company=' + name; 

    if(name != null)
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/add_company.php',
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
                        url: '../../controls/view_all_company.php',
                        success: function(html)
                        {
                            $('#add-success').html('<center><i class="fas fa-check"></i> Supplier successfully added.</center>');
                            $('#add-success').show();
                            $('#supplier-body').html(html);
                            $('#add-success').show().fadeOut(5000);
                        }
                    })
                }
                else
                {
                    $('#add-warning').html('<center><i class="fas fa-ban"></i> Adding Failed. Please call the IT administrator in local 124 for assistance.</center>');
                    $('#add-warning').show();
                    //hide the message after 3 sec
                    setTimeout(function(){
                        $('#add-warning').hide();
                    }, 3000)
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
        $('#add-warning').html('<center><i class="fas fa-ban"></i> Company field is empty.</center>');
        //hide the message after 3 sec
        setTimeout(function(){
            $('#add-warning').hide();
        }, 3000)
    }
})

//get the supplier details
$('.btnEdit').click(function(e){
    e.preventDefault();

    var id = $(this).val();
    $.ajax({
        type: 'POST',
        url: '../../controls/view_company_byID.php',
        data: {id: id},
        beforeSend: function()
        {
            showToast();
        },
        success: function(html)
        {
            $('#supplierDetailsModal').modal('show');
            $('#details-body').html(html);
        }
    })
})

//upd supplier
$('#btnUpdCompany').click(function(e){
    e.preventDefault();

    var id = $('#upd-id').val();
    var name = $('#upd-name').val();
    var myData = 'id=' + id + '&company=' + name;

    if(name != '')
    {
        $.ajax({
            type: 'POST',
            url: '../../controls/upd_company.php',
            data: myData,
            beforeSend: function()
            {
                showToast();
            },
            success: function(response)
            {
                if(response > 0)
                {
                    var table = $('#tblCompany').dataTable();
                    table.ajax.reload();
                    //display the new list of supplier
                    // $.ajax({
                    //     url: '../../controls/view_all_company.php',
                    //     success: function(html)
                    //     {
                    //         $('#upd-success').html('<center><i class="fas fa-check"></i> Supplier successfully added.</center>');
                    //         $('#upd-success').show().fadeOut(3000);
                    //         $('#company-body').html(html); 
                    //     }
                    // })
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
        url: '../../controls/delete_company.php',
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
                    url: '../../controls/view_all_company.php',
                    success: function(html)
                    {
                        $('#company-body').html(html);
                    }
                })
            }
            else
            {
                $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Failed to remove the Company. Please contact the System Administrator at local 124.<i>');
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
        url: '../../controls/activate_company.php',
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
                    url: '../../controls/view_all_company.php',
                    success: function(html)
                    {
                        $('#company-body').html(html);
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

//remove Multi Company
$('#btnMultiRemove').click(function(e){
    e.preventDefault();

    var id = []
    $('input:checkbox[name=checklist]:checked').each(function() {
         id.push($(this).val())
    });

    $.each(id, function(key, value){
        $.ajax({
            type: 'POST',
            url: '../../controls/delete_company.php',
            data: {id: value},
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
                        url: '../../controls/view_all_company.php',
                        success: function(html)
                        {
                            $('#company-body').html(html);
                        }
                    })
                }
                else
                {
                    $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Failed to Remove the Companies. Please contact the System Administrator at local 124.<i>');
                    $('#error-msg').show();
                    $('#success-msg').hide();
                    $('#errorModal').modal('show');
                }
            }
        })
    })
})
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