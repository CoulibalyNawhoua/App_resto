$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function calculePrixSousTotal($this){
    var tr = $($this).parent().parent();
    var nouvelleQuantite = tr.find('.quantity_received').val() - 0;
    var product_unit_price = tr.find('.product_unit_price').val() - 0;
    var soustotal=nouvelleQuantite*product_unit_price;
    tr.find('.sousTotal').val(Math.round(soustotal));
    calcule_prix_total()
};

function calcule_prix_total(){

    var somme = 0;
    $('.sousTotal').each(function(i, e) {
        var sousTotalLigne = $(this).val() - 0;

        if (isNaN(sousTotalLigne)){
            sousTotalLigne=0;
        }
        somme += sousTotalLigne;
    })
    $('#total_amount').val(somme);
}


$("#date_commande_id").flatpickr({
    enableTime: false,
    dateFormat: "Y-m-d",
});

$("#ReceiptForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('ReceiptForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-submit-receipt');
    var redirectURL = form.getAttribute('data-redirect');
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
            if(data.error)
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

function confirmRecevedProduct($this) {
    var tr = $($this).parent().parent();
    var quantity = tr.find('.quantity').val();
    var product_unit_price = tr.find('.product_unit_price').val();
    var subtotal = quantity * product_unit_price;
    var count = 1;
    var cart_count = $('.product_count').val() - 0;

    if ($($this).is(':checked')) {
        $($this).val(1);
        tr.find('.quantity_received').attr("readonly", false);
        tr.find('.quantity_received').attr("required", true);
        tr.find('.unite_price').attr("required", true);
        tr.find('.quantity_received').val(quantity-0);
        tr.find('.sousTotal').val(subtotal);
        calcule_prix_total();
        $('.product_count').val(cart_count + count)
    }else{
        $($this).val(0);
        tr.find('.quantity_received').attr("readonly", true);
        tr.find('.quantity_received').attr("required", false);
        tr.find('.unite_price').attr("required", false);
        tr.find('.quantity_received').val(0);
        tr.find('.sousTotal').val(0);
        $('.product_count').val(cart_count - count)
        calcule_prix_total();

    }
}

function change_unit_get_price($this) {
    var tr = $($this).parent().parent();
    var price = tr.find('.product_unit_price option:selected').attr('data-price');
    tr.find('.cout_product').val(price);

    alert(price);
    calculePrixSousTotal($this)
}

const picker = new tempusDominus.TempusDominus(document.getElementById("date_reception_id"), {
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
var DateTimeVal = moment().toDate();
picker.dates.setValue(tempusDominus.DateTime.convert(DateTimeVal))
