<?php
include '../config/clsConnection.php';
include '../objects/clsSupplier.php';

$database = new clsConnection();
$db = $database->connect();

$sup = new Supplier($db);

$view = $sup->view_suppliers();

while($row = $view->fetch(PDO::FETCH_ASSOC))
{
    if($row['status'] == 1)
    {
        $status = '<label style="color: green"><b> Active</b></label>';
    }else{
        $status = '<label style="color: red"><b> Inactive</b></label>';
    }
        echo '
        <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'"></td>
        <td>'.$row['supplier_name'].'</td>
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

<!-- get the supplier details -->
<script>
$('.btnEdit').click(function(e){
    e.preventDefault();

    var id = $(this).val();
    $.ajax({
        type: 'POST',
        url: '../../controls/view_supplier_byID.php',
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

//remove supplier
$('.btnRemove').click(function(e){
    e.preventDefault();

    var id = $(this).val();

    $.ajax({
        type: 'POST',
        url: '../../controls/delete_supplier.php',
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
                    url: '../../controls/view_all_supplier.php',
                    success: function(html)
                    {
                        $('#supplier-body').html(html);
                    }
                })
            }
            else
            {
                $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Failed to remove the Supplier. Please contact the System Administrator at local 124.<i>');
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
        url: '../../controls/activate_supplier.php',
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
                    url: '../../controls/view_all_supplier.php',
                    success: function(html)
                    {
                        $('#supplier-body').html(html);
                    }
                })
            }
            else
            {
                $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Failed to Activate the Supplier. Please contact the System Administrator at local 124.<i>');
                $('#error-msg').show();
                $('#success-msg').hide();
                $('#errorModal').modal('show');
            }
        }
    })
})

//Multi Remove
$("#btnMultiRemove").click(function(){
    if(confirm("Do you really want to deactivate the selected Suppliers?"))
    {
        var id = []
        $('input:checkbox[name=checklist]:checked').each(function() { //itemid
            id.push($(this).val())
        })
    
        $.each( id, function( key, value ) {
            $.ajax({
                type: "POST",
                data: {id:value},
                url: "../../controls/delete_supplier.php",
                cache: false,

                success:function(response)
                {
                    if(response > 0)
                    {
                        //display the new list of supplier
                        $.ajax({
                            url: '../../controls/view_all_supplier.php',
                            success: function(html)
                            {
                                $('#supplier-body').html(html);
                                $('.checkboxall').prop('checked', false);
                            }
                        })
                    }
                    else
                    {
                        $('#error-msg').html('<i class="fas fa-times-circle"></i> ERROR! Failed to remove the Suppliers. Please contact the System Administrator at local 124.<i>');
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