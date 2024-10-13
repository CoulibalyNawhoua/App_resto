
function deleteFunction(id, url, datatable_id){
    Swal.fire({
        text: "Etes-vous sûr de vouloir supprimer cet enregistrement ?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Supprimer!",
        cancelButtonText: "Annuler",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                method:"POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    console.log(res);
                    var oTable = $('#'+datatable_id).dataTable();
                    oTable.fnDraw(false);
                    Swal.fire({
                        text: "Vous avez supprimé cet enregistrement!.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-default"
                        }
                    });
                }
            });
        }
    })
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
                $('#'+$parent_id).append('<option value=""></option>');
            }else{
                $('#'+$parent_id).append('<option value=""></option>');
            }
            for (var $i=0; $i<data.length;$i++){
                $('#'+$parent_id).append('<option data-price="'+data[$i].price+'" value="'+data[$i].id+'">'+data[$i].name+'</option>');
            }
        },
        error: function(request, status, error) {
        },
    });
}


function selectionnerOperation($parent_id) {
    $.ajax({
        url:"/operation-select/",
        type:"GET",
        cache:false,
        contentType: false,
        processData: false,
        dataType:'json',
        success:function (data) {
            // console.log(data);
            $('#'+$parent_id).empty();
            if (data.length==0){
                $('#'+$parent_id).append('<option value=""></option>');
            }else{
                $('#'+$parent_id).append('<option value=""></option>');
            }
            for (var $i=0; $i<data.length;$i++){
                $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].libelle+'</option>');
            }
        },
        error: function(request, status, error) {
        },
    });
}

function selectionnerMotifGaspillage($parent_id) {
    $.ajax({
        url:"/selectionner-motif-gaspillage/",
        type:"GET",
        cache:false,
        contentType: false,
        processData: false,
        dataType:'json',
        success:function (data) {
            $('#'+$parent_id).empty();
            if (data.length==0){
                $('#'+$parent_id).append('<option value=""></option>');
            }else{
                $('#'+$parent_id).append('<option value=""></option>');
            }
            for (var $i=0; $i<data.length;$i++){
                $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].libelle+'</option>');
            }
        },
        error: function(request, status, error) {
        },
    });
}

function selectionnerTypeAjustement($parent_id) {
    $.ajax({
        url:"/type-ajustement-select/",
        type:"GET",
        cache:false,
        contentType: false,
        processData: false,
        dataType:'json',
        success:function (data) {
            $('#'+$parent_id).empty();
            if (data.length==0){
                $('#'+$parent_id).append('<option value=""></option>');
            }else{
                $('#'+$parent_id).append('<option value=""></option>');
            }
            for (var $i=0; $i<data.length;$i++){
                $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].libelle+'</option>');
            }
        },
        error: function(request, status, error) {
        },
    });
}



// function selectionnerOperationTypeEntryStock($parent_id) {
//     $.ajax({
//         url:"/operation-entry-stock-select/",
//         type:"GET",
//         cache:false,
//         contentType: false,
//         processData: false,
//         dataType:'json',
//         success:function (data) {
//             // console.log(data);
//             $('#'+$parent_id).empty();
//             if (data.length==0){
//                 $('#'+$parent_id).append('<option value=""></option>');
//             }else{
//                 $('#'+$parent_id).append('<option value=""></option>');
//             }
//             for (var $i=0; $i<data.length;$i++){
//                 $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].libelle+'</option>');
//             }
//         },
//         error: function(request, status, error) {
//         },
//     });
// }

// function selectionnerOperationTypeOutputStock($parent_id) {
//     $.ajax({
//         url:"/operation-output-stock-select/",
//         type:"GET",
//         cache:false,
//         contentType: false,
//         processData: false,
//         dataType:'json',
//         success:function (data) {
//             // console.log(data);
//             $('#'+$parent_id).empty();
//             if (data.length==0){
//                 $('#'+$parent_id).append('<option value=""></option>');
//             }else{
//                 $('#'+$parent_id).append('<option value=""></option>');
//             }
//             for (var $i=0; $i<data.length;$i++){
//                 $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].libelle+'</option>');
//             }
//         },
//         error: function(request, status, error) {
//         },
//     });
// }

function errorMessage(dataMessage,parent_id) {
    $('#'+parent_id).html(
        '<div class="alert border border-danger alert-dismissible  d-flex flex-column flex-sm-row p-5 mb-10">' +
        '<div class="d-flex flex-column text-light pe-0 pe-sm-10">' +
        '<ul class="text-danger">' + dataMessage + '</ul>' +
        '</div>' +
        '<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">' +
        /* '<span class="svg-icon svg-icon-2x svg-icon-light">' +*/
        '<i class="bi text-danger bi-x-circle"></i>'+
        /* '</span>' +*/
        '</button>' +
        '</div>'
    );
}
function functionSenderAction(id, url, datatable_id){
    Swal.fire({
        text: "voulez vous réellement effectuer cette action.?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Confirmer!",
        cancelButtonText: "Annuler",
        customClass: {
            confirmButton: "btn fw-bold btn-success",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                method:"POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    console.log(res);
                    var oTable = $('#'+datatable_id).dataTable();
                    oTable.fnDraw(false);
                    Swal.fire({
                        text: "Action effectuée avec succès.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-default"
                        }
                    });
                }
            });
        }
    });
}

$('#closed-procurement-process').on('click', function (){
    var redirectURL = $(this).attr("data-redirect");
    var procurement_id = $(this).attr("data-procurement")
    $.ajax({
        method:"POST",
        url: 'closed-procurement-process',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: procurement_id },
        dataType: 'json',
        success: function(res){
            Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
                window.location = redirectURL;
            });
        }
    });
});

$('#accepted-procurement-process').on('click', function (){
    var redirectURL = $(this).attr("data-redirect");
    var procurement_id = $(this).attr("data-procurement")
    $.ajax({
        method:"POST",
        url: 'accepted-procurement-process',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: procurement_id },
        dataType: 'json',
        success: function(res){
            Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
                window.location = redirectURL;
            });
        }
    });
});

$('#rejected-procurement-process').on('click', function (){
    var redirectURL = $(this).attr("data-redirect");
    var procurement_id = $(this).attr("data-procurement")
    $.ajax({
        method:"POST",
        url: 'rejected-procurement-process',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: procurement_id },
        dataType: 'json',
        success: function(res){
            Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
                window.location = redirectURL;
            });
        }
    });
});

$('#cancel-receipt-process').on('click', function (){
    var redirectURL = $(this).attr("data-redirect");
    var id = $(this).attr("data-receipt");
    var note = document.getElementById("note_id").value
    $.ajax({
        method:"POST",
        url: 'cancel-receipt-process',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: id , note:note},
        dataType: 'json',
        success: function(res){
            Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
                window.location = redirectURL;
            });
        }
    });
});


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////action commande
$('#accept-order-process').on('click', function (){
    var redirectURL = $(this).attr("data-redirect");
    var order_id = document.getElementById("order_id").value
    var note = document.getElementById("note_id").value
    $.ajax({
        method:"POST",
        url: 'accept-order-process',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { order_id: order_id, note:note },
        dataType: 'json',
        success: function(res){
            Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
                window.location = redirectURL;
            });
        }
    });
});

$('#cancel-order-process').on('click', function (){
    var redirectURL = $(this).attr("data-redirect");
    var order_id = document.getElementById("order_id").value
    var note = document.getElementById("note_id").value
    $.ajax({
        method:"POST",
        url: 'cancel-order-process',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { order_id: order_id, note:note },
        dataType: 'json',
        success: function(res){
            Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
                window.location = redirectURL;
            });
        }
    });
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function unit_group_select_product($parent_id, productId) {
    $.ajax({
        url:"/unit-group-select-product/",
        type:"GET",
        data : { productId : productId },
        success:function (data) {
            $('#'+$parent_id).empty();
            if (data.length==0){
                $('#'+$parent_id).append('<option value="">Aucun</option>');
            }else{
                $('#'+$parent_id).append('<option value=""></option>');
            }
            for (var $i=0; $i<data.length;$i++){
                $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].name+'</option>');
            }
        },
        error: function(request, status, error) {
        },
    });
}


function selectUnitForGroupUnit($this){

    var tr = $($this).parent().parent();

    var productId = tr.find('.product_id').val();

    var parent_id =  tr.find('.unit_id').attr('id');

    unit_group_select_product(parent_id, productId)

};


function produit_select($parent_id) {
    $.ajax({
        url:"/produit-select/",
        type:"GET",
        success:function (data) {
            // console.log(data);
            $('#'+$parent_id).empty();
            if (data.length==0){
                $('#'+$parent_id).append('<option value="">Aucun</option>');
            }else{
                $('#'+$parent_id).append('<option value="">Aucun</option>');
            }
            for (var $i=0; $i<data.length;$i++){
                $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].nom_produit+'</option>');
            }
        },
        error: function(request, status, error) {
        },
    });
}


function unit_select($parent_id) {
    $.ajax({
            url:"/unit-select/",
            type:"POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                    $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].name+'</option>');
                }
            },
            error: function(request, status, error) {
        },
    });
}
