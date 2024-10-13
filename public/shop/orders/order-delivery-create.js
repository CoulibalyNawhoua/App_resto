
$("#OrderDeliveryForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('OrderDeliveryForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-submit-delivery-order');
    var redirectURL = form.getAttribute('data-redirect')
    var formData = new FormData(form);
    $.ajax({
        url:action,
        method:'POST',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend:function(){
            submitButton.setAttribute('data-kt-indicator', 'on');
            submitButton.disabled = true;
        },
        success:function(data)
        {
            var errors = data.error;

           if(errors)
            {
                var dataMessage = '';
                for(var count = 0; count < data.error.length; count++)
                {
                    dataMessage += '<li>'+data.error[count]+'</li>';
                }
                errorMessage(dataMessage,'message')
            }
            else
            {
                Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
                    window.location = redirectURL;
                });
            }
            submitButton.disabled = false;
        },
        complete: function() {
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
        },
    })

});
function addProduct($this) {
    var count = 1;
    var cart_count = $('.product_count').val() - 0;
    if ($($this).is(':checked')) {
        $($this).val(1);
        $('.product_count').val(cart_count + count)
    }else
    {
        $($this).val(0);
        $('.product_count').val(cart_count - count);
    }
}
function confirmDeliveryProduct($this) {
    var tr = $($this).parent().parent();
    var quantity = tr.find('.order_qantity').val() - 0;
    if (isNaN(quantity)){
        quantity=0;
    }
    var count = 1;
    var cart_count = $('.product_count').val() - 0;
    if ($($this).is(':checked')) {
        $($this).val(1);
        tr.find('.quantity_delivery').attr("readonly", false);
        tr.find('.quantity_delivery').attr("required", true);
        tr.find('.quantity_delivery').val(quantity-0);
        $('.product_count').val(cart_count + count)
    }else{
        $($this).val(0);
        tr.find('.quantity_delivery').attr("readonly", true);
        tr.find('.quantity_delivery').attr("required", false);
        tr.find('.quantity_delivery').val(0);
        $('.product_count').val(cart_count - count)

    }
}
var DateTimeVal = moment().toDate();

const date_commande = new tempusDominus.TempusDominus(document.getElementById("date_commande_id"), {
    localization: {
        /* locale: "de",*/
        startOfTheWeek: 1,
        format: "yyyy-MM-dd",
    },
    display: {
        viewMode: "calendar",
        components: {
            decades: true,
            year: true,
            month: true,
            date: true,
            hours: false,
            minutes: false,
            seconds: false
        }
    },
});


const delivery_date = new tempusDominus.TempusDominus(document.getElementById("delivery_date_id"), {
    localization: {
        /* locale: "de",*/
        startOfTheWeek: 1,
        format: "yyyy-MM-dd",
    },
    display: {
        viewMode: "calendar",
        components: {
            decades: true,
            year: true,
            month: true,
            date: true,
            hours: false,
            minutes: false,
            seconds: false
        }
    },
});
delivery_date.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal))


const delivery_add_date = new tempusDominus.TempusDominus(document.getElementById("delivery_add_date_id"), {
    localization: {
        /* locale: "de",*/
        startOfTheWeek: 1,
        format: "yyyy-MM-dd",
    },
    display: {
        viewMode: "calendar",
        components: {
            decades: true,
            year: true,
            month: true,
            date: true,
            hours: false,
            minutes: false,
            seconds: false
        }
    },
});
delivery_add_date.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal))
