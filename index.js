$(document).ready(function(){
    //datepicker
    $('.datepicker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoClose: true
    });
    //webfont
    WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
            families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
            ],
            urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
            sessionStorage.fonts = true;
        },
    });
    //show / hide the button on schedule
    showhide();
})
//show / hide the button on schedule function
function showhide()
{
    //get the current day of the week
    var days = ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'];
    var today = new Date().getDay();
    //get the current time of the day
    // var start = 9;
    // var end = 15;
    // var currentHour = new Date().getHours();

    //check the day of the week
    if(today == 1 || today == 2){
        $('#msgGroup').hide(); //hide the message
        $('#btnGroup').show(); //show the button
        //check the time of the day
        // if(currentHour >= start && currentHour <= end){
    }else{
        //hide the button and show the message
        $('#msgGroup').show(); //hide the message
        $('#btnGroup').hide(); //show the button
        $('#linkGroup').hide();
        $('#dayToday').html('<b>CURRENT DAY:</b> ' + days[today]);
    }
}
//autocomplete event handler
$('#company').keyup(function() {
    var comp_length = $(this).val();
    if (comp_length.length > 2) {
        $(this).autocomplete({
            source: ["INNOLAND DEVELOPMENT CORPORATION", "ABIATHAR CORPORATION", "CITRINELAND DEVELOPMENT CORPORATION", "OHMORI DEVELOPMENT CORP", "INDUCO RESOURCE CONSTRUCTION CORPORATION", "INNOPRIME PROPERTY SERVICES INC", "ONGTIAK DEVELOPMENT CORP", "TG UNIVERSAL BUSINESS VENTURES CORP", "VELSONS MANAGEMENT & DEVELOPMENT CORPORATION", "TOYO BATANGAS", "SOPHIATRADE CORPORATION", "AEONPRIME LAND DEVELOPMENT CORP", "JANCOT FIEMA INCORPORATED", "ATRIAPRIME DEVELOPMENT CORPORATION", "EXCEL TOWERS INCORPORATED", "MJ LANDTRADE DEVELOPMENT CORP.", "AMBERINE CORPORATION", "AULENI RESORT CORPORATION", "AVEN TURINE DEVELOPMENT CORPORATION", "BUENAVICTORIA", "DOMINALAND INC", "GRAND CENTAURI", "IDEALUXE CORPORATION", "JQUARTZ DYNAMICS CORPORATION", "LEGATTA BEA PROPERTIES CORPORATION", "NEKOME LAND DEVELOPMENT CORPORATION", "OMNI PROMISELAND", "OUTLOOK MATTHEWS PROPERTY HOLDINGS INC.", "AEON CENTER", "TEST COMPANY"]
        });
    }else{
        $(this).autocomplete('destroy');
    }
})
//submit request
function submit()
{
    Swal.fire({
        title: "Are you sure you want to submit this request?",
        text: "Please make sure that all the data and attachement are correct before submitting.",
        showDenyButton: true,
        confirmButtonText: "Submit",
        denyButtonText: `Cancel`
      }).then((result) => {
        if (result.isConfirmed) {
            var code = $('#code').val().toUpperCase();
            var vendor_name = encodeURIComponent($('#vendor-name').val().toUpperCase());
            var po_num = $('#po-num').val();
            var si_num = $('#si-num').val();
            var si_amount = $('#si-amount').val();
            var email = $('#email').val();
            var vendor_no = $('#vendor-no').val();
            var company = $('#company').val();
            var si_date = $('#si-date').val();
            var myData = 'code=' + code + '&vendor_name=' + vendor_name + '&po_num=' + po_num + '&si_num=' + si_num + '&si_amount=' + si_amount + '&email=' + email + '&vendor_no=' + vendor_no + '&company=' + company + '&si_date=' + si_date + '&vendor_name=' + vendor_name;
        
            if(code != '' && po_num != '' && si_num != '' && si_amount != '' && email != '' && company != '' && si_date != ''){
                //submission of data
                $.ajax({
                    type: "POST",
                    url: "controls/save_data.php",
                    data: myData,
                    success: function(response)
                    {
                        if(response == 0){
                            Swal.fire({
                                icon: "error",
                                title: "Failed to save your request. Please try again."
                            });                    
                        }else{
                            Swal.fire({
                                icon: "success",
                                title: "Data Successfully submitted. REF NUM: " + response,
                                text: "NOTE: Please write down the reference number or check your email for other details."
                            });
                            //check the supplier data
                            check_vendor_data();
                            clear_data();
                        }
                    }
                })
            }else{
                Swal.fire({
                    icon: "error",
                    title: "Failed to Submit. Please fill out all the necessary data needed."
                });
            }
        } else if (result.isDenied) {
          Swal.fire("Changes are not saved", "", "info");
        }
      });
}
//format currency value of Amount
$('#si-amount').on('blur', function(e) {
    if($(this).val() != ''){
            //convert into currency format
            const value = this.value.replace(/,/g, '');
            this.value = parseFloat(value).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigits: 2,
            minimumFractionDigits: 2
        });
    }else{
        this.value = '0.00';
    }
    //disabled alphabet
    this.value = this.value.replace(/[a-zA-ZD&\/\\!#+()$~%'":*?<>{}]/g, '');
})
function check_vendor()
{
    var code = $('#code').val();
    var vendor_name = $('#vendor-name').val();
    //alert(vendor_name);
    $.ajax({
        type: 'POST',
        url: 'controls/check_vendor.php',
        data: {code: code},
        dataType: 'json',
        cache: false,
        success: function(result)
        {
            var link = result[0];
            var name = result[1];
            var email = result[2];
            var num = result[3];
            //display the link provided in form
            $('#link').html(link);
            $('#vendor-name').val(name);
            $('#email').val(email);
            $('#vendor-no').val(num);
        }
    })
}
function check_vendor_data()
{
    var code = $('#code').val();
    var email = $('#email').val();
    var contact = $('#vendor-no').val();

    var myData = 'code=' + code + '&email=' + email + '&contact=' + contact;
    $.ajax({
        type: 'POST',
        url: 'controls/check_vendor_data.php',
        data: myData,
        success: function(response)
        {
           //do nothing. . .
        }        
    })
}
//check if the code is correct
$('#code').on('blur', function(){
    $('#vendor-name').val('');
    $('#link').html('<i class="fa-sharp fa-solid fa-upload"></i> A link will be created here.');
    setTimeout(function(){
        if($('#vendor-name').val() == '' || $('#vendor-name').val() == null){
            Swal.fire({
                icon: "error",
                title: "Vendor code not found in database."
            });
        }
    }, 300)
})
//restrict special characters
$('input').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9-@.]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});
//clear
function clear_data()
{
    $('input[type=text]').val('');
    $('input[type=password]').val('');
    $('.select2').val('0').trigger('change');
    $('#link').html('<i class="fa-sharp fa-solid fa-upload"></i> A link will be created here.');
}