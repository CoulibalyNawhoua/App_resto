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

$("#date_reception_id").flatpickr({
    enableTime: false,
    // dateFormat: "Y-m-d H:i:s"
});

$("#ReceiptForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('ReceiptForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-save-receipt');
    var redirectURL = form.getAttribute('data-redirect');
    var formData = new FormData(form);

    let x = document.getElementById("product_count").value;

    if (isNaN(x) || x < 1 ) {
        alert('veuillez cocher la case correspondant aux produits reçus');
        return false;
    }
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
                var error_html = '';
                for(var count = 0; count < data.error.length; count++)
                {
                    error_html += '<li>'+data.error[count]+'</li>';
                }

                $('#message').html(
                    '<div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">'+
                        '<div class="d-flex flex-column text-light pe-0 pe-sm-10">'+
                            '<ul>'+ error_html +'</ul>'+
                        '</div>'+
                        '<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">'+
                            '<span class="svg-icon svg-icon-2x svg-icon-light">'+
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'+
                                    '<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>'+
                                    '<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>'+
                                '</svg>'+
                            '</span>'+
                        '</button>'+
                    '</div>'
                );
            }
            else
            {
                Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {

                    console.log(data);
                    // window.location = redirectURL;
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
    var purchase_price = tr.find('.purchase_price').val();
    var quantity_received = tr.find('.quantity_received').attr("data-quantity-received");
    var subtotal = quantity_received * purchase_price;
    var count = 1;
    var cart_count = $('.product_count').val();
    if ($($this).is(':checked')) {
        $($this).val(1);
        tr.find('.quantity_received').attr("readonly", false);
        tr.find('.quantity_received').attr("required", true);
        tr.find('.purchase_price').attr("required", true);
        tr.find('.quantity_received').val(quantity_received);
        tr.find('.subtotal').val(subtotal);
        calcule_prix_total();
        $('.product_count').val(cart_count + count)
    }else{
        $($this).val(0);
        tr.find('.quantity_received').attr("readonly", true);
        tr.find('.quantity_received').attr("required", false);
        tr.find('.purchase_price').attr("required", false);
        tr.find('.quantity_received').val(quantity_received);
        tr.find('.subtotal').val(0);
        $('.product_count').val(cart_count - count)
        calcule_prix_total();

    }
}
