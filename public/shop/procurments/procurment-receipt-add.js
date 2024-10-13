$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
function calculePrixSousTotal($this){
    var tr = $($this).parent().parent();
    var nouvelleQuantite = tr.find('.quantity_received').val() - 0;
    var coutProduit = tr.find('.purchase_price').val() - 0;
    var soustotal=nouvelleQuantite*coutProduit;
    tr.find('.subtotal').val(Math.round(soustotal));
    calcule_prix_total()
};

function calcule_prix_total(){

    var somme = 0;
    $('.subtotal').each(function(i, e) {
        var sousTotalLigne = $(this).val() - 0;

        if (isNaN(sousTotalLigne)){
            sousTotalLigne=0;
        }
        somme += sousTotalLigne;
    })
    $('#totalReceiptPrice').val(somme);
}

// var KTInitProcurement = function() {
//     var i=0;
//     var p=0;
//     function ProductAuPanier(donnees){
//         p++;

//         if( $('#tr-1').length){
//             $('#tr-1').remove();
//         }
//         var rowCount = $("#tabpanier-id tr").length;

//         if( $('#product_'+donnees.id).length){
//            var quantite= $('#qte-'+p).value;
//            quantite++;
//            $('#qte-'+p).val(quantite);
//             return ;
//         }

//         $('#tabpanier-id').append(
//             '<tr id="tab_ligne-'+p+'">'+
//             '<input type="hidden" name="products[]" id="product_'+donnees.id+'" value="'+donnees.id+'"/>'+
//             '<td class="w-500px">'+donnees.nom_produit+'</td>'+
//             '<td class="w-300px">'+
//                     '<input type="text" id="qte-'+p+'" required name="quantite[]" min="1" class="form-control  h-30px p-0 quantity_received" value="1" onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/>'+
//             '</td>'+
//             '<td class="w-300px">'+
//                     '<input type="text" id="purchase_price-'+p+'" readonly name="purchase_price[]" class="form-control  h-30px p-0 purchase_price" value="'+donnees.prix_achat+'"/>'+
//             '</td>'+
//             '<td class="w-300px sous-total">'+
//                     '<input type="text" id="sousTotal-'+p+'" readonly name="subtotal[]" class="form-control  h-30px p-0 subtotal" value="'+donnees.prix_achat+'"/>'+
//              '</td>'+
//             '<td class="fw-bold flex-right">'+
//                 '<a href="javascript:;" id="'+p+'" onclick="deleteSub(this, 0);" class="btn btn-icon btn-danger panier_btn_remove pulse h-30px w-30px">'+
//                     '<span class="svg-icon svg-icon-2">'+
//                         '<i class="fa fa-bold fa-close"></i>'+
//                     '</span>'+
//                     '<span class="pulse-ring"></span>'+
//                 '</a>'+
//             '</td>'+
//         '</tr>'
//         );
//         $('#tabpanier-id').trigger('rowAddOrRemove');
//     };

//     $('#search-product-select2').on('select2:select', function (e) {
//         var cart_count = $('.product_count').val() - 0;
//         var product_id = $(this).val()
//         $.ajax({
//             type:"POST",
//             url: "/get-single-product/",
//             headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             data : { product_id : product_id },
//             dataType: 'json',
//             success: function(resp){
//                 console.log(resp);
//                 ProductAuPanier(resp);
//                 $("#search-product-select2").val(null).trigger('change.select2');
//                 $('.product_count').val(cart_count + 1)
//             }
//         });
//     });

//     $('#tabpanier-id').bind('rowAddOrRemove',function(event){
//         calcule_prix_total();
//     });

// 	return {
// 		init: function() {
// 		},
// 	};
// }();

// KTUtil.onDOMContentLoaded(function () {
//     KTInitProcurement.init();
// });



$("#ReceiptForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('ReceiptForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-save-receipt');
    var redirectURL = form.getAttribute('data-redirect');
    var formData = new FormData(form);

/*    let x = document.getElementById("product_count").value;

    if (isNaN(x) || x < 1 ) {
        alert('veuillez cocher la case correspondant aux produits reçus');
        return false;
    }*/
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
    var quantity = tr.find('.quantity').val() - 0;
    var purchase_price = tr.find('.purchase_price').val();
    var subtotal = quantity * purchase_price;
    var count = 1;
    var cart_count = $('.product_count').val() - 0;
    if ($($this).is(':checked')) {
        $($this).val(1);
        tr.find('.quantity_received').attr("readonly", false);
        tr.find('.purchase_price').attr("readonly", false);
        tr.find('.quantity_received').attr("required", true);
        tr.find('.purchase_price').attr("required", true);
        tr.find('.quantity_received').val(quantity);
        tr.find('.subtotal').val(subtotal);
        calcule_prix_total();
        $('.product_count').val(cart_count + count)
    }else{
        $($this).val(0);
        tr.find('.quantity_received').attr("readonly", true);
        tr.find('.purchase_price').attr("readonly", true);
        tr.find('.quantity_received').attr("required", false);
        tr.find('.purchase_price').attr("required", false);
        tr.find('.quantity_received').val(0);
        tr.find('.subtotal').val(0);
        $('.product_count').val(cart_count - count)
        calcule_prix_total();
    }
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

