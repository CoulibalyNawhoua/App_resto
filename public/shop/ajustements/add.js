var KTpdv = function () {
    // var i=0;
    // var p=0;
    // function ProductAuPanier(donnees){
    //     p++
    //     if( $('#tr-1').length){
    //         $('#tr-1').remove();
    //     }
    //     var rowCount = $("#tabpanier-id tr").length;

    //     if( $('#product_'+donnees.id).length){
    //         var quantite= $('#qte-'+p).value;
    //         quantite++;
    //         $('#qte-'+p).val(quantite);
    //         return ;
    //     }
    //     //verifier l'existance d
    //     $('#tabpanier-id').append(
    //         '<tr id="tab_ligne-'+p+'" class="dynamic-added">'+
    //             '<input type="hidden" name="products[]" id="product_'+donnees.stock_id+'" value="'+donnees.stock_id+'"/>'+
    //             '<td class="w-400px">'+donnees.nom_produit+' ('+donnees.quantite+' '+donnees.unite_gestion+')</td>'+
    //             '<td class="w-300px">'+
    //                 '<select name="unite[]" style="background-color: #e9ecef" class="form-select h-30px p-1 rounded-0 product_unit"  required id="unit_id'+p+'"></select>' +
    //             '</td>'+
    //             '<td class="w-400px">'+
    //                 '<select name="type_ajustement[]" style="background-color: #e9ecef"  class="form-select form-select-solid h-30px p-1 rounded-0 type_ajustement"  required id="type_ajustement_id'+p+'"></select>' +
    //             '</td>'+
    //             '<td class="w-300px">'+
    //                 '<input type="number" id="qte-'+p+'" required name="quantite[]" min="1" class="form-control easy-put rounded-0 h-30px p-1 quantity_product" value="1"/>'+
    //             '</td>'+
    //             '<td class="fw-bold flex-right w-30px">'+
    //                 '<a href="javascript:;" id="'+p+'" class="btn btn-icon btn-danger rounded-circle panier_btn_remove pulse h-30px w-30px">'+
    //                 '<span class="svg-icon svg-icon-2">'+
    //                     '<i class="fa fa-bold fa-close"></i>'+
    //                 '</span>'+
    //                 '<span class="pulse-ring"></span>'+
    //                 '</a>'+
    //             '</td>'+
    //         '</tr>'
    //     );
    //     $('#tabpanier-id').trigger('rowAddOrRemove');
    //     var cart_count = $('.product_count').val() - 0;
    //     $('.product_count').val(cart_count + 1);
    //     var unit_id = "unit_id"+p;
    //     var type_ajustement_id = "type_ajustement_id"+p;
    //     unit_group_select_product(unit_id, donnees.id);
    //     selectionnerTypeAjustement(type_ajustement_id);
    // };
    // //actualliser le calcule
    // $(document).on('click', '.panier_btn_remove', function(){
    //     var button_id = $(this).attr("id");
    //     var count = 1;
    //     $('#tab_ligne-'+button_id+'').remove();
    //     $('#tabpanier-id').trigger('rowAddOrRemove');
    //     var cart_count = $('.product_count').val() - 0;
    //     $('.product_count').val(cart_count - count)
    //     var Tableau_ligne = $("#tabpanier-id td").closest("tr").length;
    //     if(Tableau_ligne==0){
    //         $('#tabpanier-id').append(
    //             '<tr id="tr-1">'+
    //             '<td width="25%"></td>'+
    //             '<td width="50%" class="align-items-center flex-center  text-align-center">Aucun produit selectionné!</td>'+
    //             '<td width="25%"></td>'+
    //             '</tr>'
    //         );
    //     }
    //     //actualliser le calcule
    // });
    //typeahead pour la recherche des produit
    // var searchEngine  = new Bloodhound({
    //     datumTokenizer: Bloodhound.tokenizers.whitespace,
    //     queryTokenizer: Bloodhound.tokenizers.whitespace,
    //     remote: {
    //         url: "/search-product-stock-depot?q=query",
    //         wildcard: '%QUERY%',
    //         prepare: function (query, settings) {
    //             settings.url = settings.url.replace('query', query);
    //             return settings;
    //         },
    //         limite: 10,
    //     }
    // });
    // searchEngine.initialize();
    // $('#product_search').typeahead({
    //         hint: true,
    //         highlight: true,
    //         minLength: 1
    //     },
    //     {
    //         name: 'q',
    //         source: searchEngine,
    //         limit: 10,
    //         display: function (data) {
    //             return data.nom_produit
    //         },
    //         templates: {
    //             empty: [
    //                 '<div class="empty-message">',
    //                 'impossible de trouver les produits qui correspondent à la requête actuelle',
    //                 '</div>'
    //             ].join('\n'),
    //             suggestion: function(data) {
    //                 return '<div><strong>'+ data.nom_produit +'</strong></div>';
    //             }
    //         }
    //     })
    //     .on('typeahead:selected', function (obj, itemData) {
    //         $.ajax({
    //             url:"/get-single-product-depot/",
    //             type:"GET",
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             data : { product_id : itemData.id },
    //             success:function (resp) {
    //                 ProductAuPanier(resp)
    //                 $('#product_search').typeahead('val', '');
    //             },
    //             error: function(request, status, error) {
    //             },
    //         });
    //     });

    return {
        init: function() {
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTpdv.init();
});

$("#btn-submit-form").on("click",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('addForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-submit-form');
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
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
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
                    // console.log(data);
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
            '<input type="hidden" name="products[]" id="product_'+donnees.stock_id+'" value="'+donnees.stock_id+'"/>'+
            '<td class="w-400px">'+donnees.nom_produit+' ('+donnees.quantite+' '+donnees.unite_gestion+')</td>'+
            '<td class="w-300px">'+
                '<select name="unite[]" style="background-color: #e9ecef" class="form-select h-30px p-1 rounded-0 product_unit"  required id="unit_id'+p+'"></select>' +
            '</td>'+
            '<td class="w-400px">'+
                '<select name="type_ajustement[]" style="background-color: #e9ecef"  class="form-select form-select-solid h-30px p-1 rounded-0 type_ajustement"  required id="type_ajustement_id'+p+'"></select>' +
            '</td>'+
            '<td class="w-300px">'+
                '<input type="number" id="qte-'+p+'" required name="quantite[]" min="1" class="form-control easy-put rounded-0 h-30px p-1 quantity_product" value="1"/>'+
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
    var type_ajustement_id = "type_ajustement_id"+p;
    unit_group_select_product(unit_id, donnees.id);
    selectionnerTypeAjustement(type_ajustement_id);
};
//actualliser le calcule
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
    //actualliser le calcule
});


 var url = "/search-product-stock-depot?q=query";


 searchProduct(url);

 function searchProduct(url) {
    var searchEngine  = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: url,
            wildcard: '%QUERY%',
            prepare: function (query, settings) {
                settings.url = settings.url.replace('query', query);
                return settings;
            },
            limite: 10,
        }
    });
    searchEngine.initialize();
    $('#product_search').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'q',
            source: searchEngine,
            limit: 10,
            display: function (data) {
                return data.nom_produit
            },
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'impossible de trouver les produits qui correspondent à la requête actuelle',
                    '</div>'
                ].join('\n'),
                suggestion: function(data) {
                    return '<div><strong>'+ data.nom_produit +'</strong></div>';
                }
            }
        })
        .on('typeahead:selected', function (obj, itemData) {
            $.ajax({
                url:"/get-single-product-depot/",
                type:"GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : { product_id : itemData.id },
                success:function (resp) {
                    ProductAuPanier(resp)
                    $('#product_search').typeahead('val', '');
                },
                error: function(request, status, error) {
                },
            });
        });
 }

