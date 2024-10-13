var i=0;
var p=0;
function ProductAuPanier(donnees){
    p++
    if( $('#tr-1').length){
        $('#tr-1').remove();
    }
    var rowCount = $("#tabpanier-id tr").length;

    if( $('#product_'+donnees.id).length){
        var quantite= $('#qte-'+p).value;
        quantite++;
        $('#qte-'+p).val(quantite);
        return ;
    }
    //verifier l'existance d
    $('#tabpanier-id').append(
        '<tr id="tab_ligne-'+p+'" class="dynamic-added">'+
            '<input type="hidden" name="products[]" id="product_'+donnees.id+'" value="'+donnees.id+'"/>'+
            '<td class="w-400px">'+donnees.nom_produit+'<span style="color: red"> ('+donnees.name+')</span></td>'+
            '<td class="w-300px">'+
                '<select name="unite[]" style="background-color: #e9ecef" class="form-select h-30px p-1 rounded-0 product_unit"  required id="unit_id'+p+'"></select>' +
            '</td>'+
            '<td class="w-300px">'+
                '<input type="number" id="qte-'+p+'" required name="quantite[]" min="0.1" step="0.1" class="form-control easy-put rounded-0 h-30px p-1 quantity_product" value="1"/>'+
            '</td>'+
            '<td class="fw-bold flex-right w-30px">'+
                '<a href="javascript:;" id="'+p+'" class="btn btn-icon btn-danger rounded-circle panier_btn_remove pulse h-30px w-30px">'+
                '<span class="svg-icon svg-icon-2">'+
                    '<i class="fa fa-bold fa-close"></i>'+
                '</span>'+
                '<span class="pulse-ring"></span>'+
                '</a>'+
            '</td>'+
        '</tr>'
    );
    $('#tabpanier-id').trigger('rowAddOrRemove');
    var cart_count = $('.product_count').val() - 0;
    $('.product_count').val(cart_count + 1);
    var unit_id = "unit_id"+p;
    unit_group_select_product(unit_id, donnees.id);
};

$('#select-product').on('select2:select', function (e) {
    var cart_count = $('.product_count').val() - 0;
    var product_id = $(this).val()
    $.ajax({
        type:"POST",
        url: "/get-single-product/",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : { product_id : product_id },
        dataType: 'json',
        success: function(resp){
            console.log(resp);
            ProductAuPanier(resp);
            $("#select-product").val(null).trigger('change.select2');
            // $('.product_count').val(cart_count + 1)
        }
    });
});
$(document).on('click', '.panier_btn_remove', function(){
    var button_id = $(this).attr("id");
    var count = 1;
    $('#tab_ligne-'+button_id+'').remove();
    $('#tabpanier-id').trigger('rowAddOrRemove');
    var cart_count = $('.product_count').val() - 0;
    $('.product_count').val(cart_count - count)
    var Tableau_ligne = $("#tabpanier-id td").closest("tr").length;
    if(Tableau_ligne==0){
        $('#tabpanier-id').append(
            '<tr id="tr-1">'+
            '<td width="25%"></td>'+
            '<td width="50%" class="align-items-center flex-center  text-align-center">Aucun produit selectionné!</td>'+
            '<td width="25%"></td>'+
            '</tr>'
        );
    }
});
$("#btn-submit-form").on("click",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('form');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-submit-form');
    var redirectURL = form.getAttribute('data-redirect')
    var formData = new FormData(form)
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