<?php
include '../config/clsConnection.php';
include '../objects/clsCompany.php';

$database = new clsConnection();
$db = $database->connect();

$company = new Company($db);

$view = $company->view_company();

while($row = $view->fetch(PDO::FETCH_ASSOC))
{
    if($row['status'] == 1)
    {
        $status = '<label style="color: green"><b> Active</b></label>';
    }else{
        $status = '<label style="color: red"><b> Inactive</b></label>';
    }
    echo'
        <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'"></td>
        <td>'.$row['company'].'</td>
        <td><center>'.$status.'</center></td>
        <td>';
            if($row['status'] == 1)
            {
            echo '<center><button class="btn btn-info btn-sm btnEdit" value="'.$row['id'].'"><i class="fas fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm btnRemove" value="'.$row['id'].'"><i class="fas fa-trash"></i> Remove</button></center>';
            }
            else
            {
            echo '<center><button class="btn btn-info btn-sm btnEdit" value="'.$row['id'].'"><i class="fas fa-edit"></i> Edit</button>
            <button class="btn btn-success btn-sm btnActivate" value="'.$row['id'].'"><i class="fas fa-check"></i> Activate</button></center>';
            }
            echo '</td>
        </tr>';
}
?>

<script>
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
                alert(response);
                if(response > 0)
                {
                    //display the new list of supplier
                    $.ajax({
                        url: '../../controls/view_all_company.php',
                        success: function(html)
                        {
                            $('#upd-success').html('<center><i class="fas fa-check"></i> Supplier successfully added.</center>');
                            $('#upd-success').show().fadeOut(3000);
                            $('#company-body').html(html); 
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