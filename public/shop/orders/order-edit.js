function calculePrixSousTotal($this){
    var tr = $($this).parent().parent();
    var nouvelleQuantite = tr.find('.quantite_product').val() - 0;
    var coutProduit = tr.find('.cout_product').val() - 0;
    var soustotal=nouvelleQuantite*coutProduit;
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
    $('#total_a_payer_id').val(somme);
}

var KTInitProcurement = function() {
    var i=0;
    var p=0;
    function ProductAuPanier(donnees){
        p++;
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
        $('#tabpanier-id').append(
            '<tr id="tab_ligne-'+p+'">'+
                '<input type="hidden" name="products[]" id="product_'+donnees.id+'" value="'+donnees.id+'"/>'+
                '<td class="w-500px" style="font-size: 10px">'+donnees.nom_produit+'</td>'+
                '<td class="w-300px">'+
                    '<select name="product_unit[]" class="form-select h-30px p-1 rounded-0 product_unit"  onchange="change_unit_get_price(this);" required id="unit_id'+donnees.id+'"></select>' +
                '</td>'+
                '<td class="w-300px">'+
                    '<input type="text" id="cout_product-'+p+'" readonly name="unite_price[]" class="form-control rounded-0 h-30px p-1 cout_product" value=""/>'+
                '</td>'+
                '<td class="w-300px">'+
                    '<input type="text" id="qte-'+p+'" required name="quantity[]" min="1" class="form-control rounded-0 h-30px p-1 quantite_product" value="1" onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/>'+
                '</td>'+
                '<td class="w-300px sous-total">'+
                    '<input type="text" id="sousTotal-'+p+'" readonly name="sousTotal[]" class="form-control rounded-0 h-30px p-1 sousTotal" value=""/>'+
                '</td>'+
                '<td class="fw-bold flex-right">'+
                    '<a href="javascript:;" id="'+p+'" class="btn btn-icon btn-danger panier_btn_remove pulse h-30px w-30px">'+
                        '<span class="svg-icon svg-icon-2">'+
                        '<i class="fa fa-bold fa-close"></i>'+
                        '</span>'+
                        '<span class="pulse-ring"></span>'+
                    '</a>'+
                '</td>'+
            '</tr>'
        );
        $('#tabpanier-id').trigger('rowAddOrRemove');
        var unit_id = "unit_id"+donnees.id;
        unit_group_select_product(unit_id, donnees.id);
    };
    $('#search-product-select2').on('select2:select', function (e) {
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
                $("#search-product-select2").val(null).trigger('change.select2');
                $('.product_count').val(cart_count + 1)
            }
        });
    });
/*    $("#date_commande_id").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        defaultDate: "today"
    });*/
	return {
		init: function() {
		},
	};
}();

KTUtil.onDOMContentLoaded(function () {
    KTInitProcurement.init();
});

$("#OrderForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('OrderForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-submit-order');
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
            console.log(data);
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


function deleteSub(el, id, product_id)
{
    var tr = $(el).parent().parent();
    var procuctName = tr.find('#productName_'+product_id).html();
    Swal.fire({
        html: 'Voulez-vous supprimer le produit <strong>'+procuctName+' </strong> de la liste de commande ?',
        icon: "error",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Oui, supprimer",
        cancelButtonText: 'Non, annuler',
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: 'btn btn-danger'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (Number(id) > 0) {
                deleteOrderItem(id)
            }
            $(el).closest("tr").remove();
            var count = 1;
            var cart_count = $('.product_count').val();
            $('.product_count').val(cart_count - count);
            calcule_prix_total();
            Swal.fire(
                'Supprimer!',
                'Le produit <strong> '+procuctName+'</strong> a été supprimer de la liste de commande avec succès !',
                'success'
            )
        }
    })
}
function deleteOrderItem(id){
    $.ajax({
        type:"POST",
        url: "delete-order-item",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data: { id: id },
        dataType: 'json',
        success: function(resp){
            console.log(resp);
        }
    });
}
function unit_product_select($parent_id, product_id) {
    $.ajax({
        url:"/unit-product-select/",
        type:"GET",
        data:{
            product_id:product_id
        },
        success:function (data) {
            // console.log(data);
            $('#'+$parent_id).empty();
            if (data.length==0){
                $('#'+$parent_id).append('<option value="">Aucun</option>');
            }else{
                $('#'+$parent_id).append('<option value="">Aucun</option>');
            }
            for (var $i=0; $i<data.length;$i++){
                $('#'+$parent_id).append('<option data-price="'+data[$i].price+'" value="'+data[$i].id+'">'+data[$i].name+' (Pcb = '+data[$i].pcb+')</option>');
            }
        },
        error: function(request, status, error) {
        },
    });
}
function change_unit_get_price($this) {
    var tr = $($this).parent().parent();
    var price = tr.find('.product_unit option:selected').attr('data-price');
    tr.find('.cout_product').val(price);
    calculePrixSousTotal($this)
}

new tempusDominus.TempusDominus(document.getElementById("date_commande_id"), {
    localization: {
        /* locale: "de",*/
        startOfTheWeek: 1,
        format: "yyyy-MM-dd HH:mm:ss",
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

