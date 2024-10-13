
$('#button-add-item').on('click', function(){
    functionAddUnit();
});

var p=1;
function functionAddUnit() {
    p++;
    $('#table-ajouter-item').append(
        '<tr class="border-bottom border-bottom-dashed" data-kt-element="item">'+
            '<input type="hidden" name="fiche_item[]" value="">'+
            '<td class="ps-0">'+
                '<select name="unites[]" class="form-select rounded-0" required id="unit_id'+p+'"></select>' +
            '<td>'+
                '<select name="produits[]" class="form-select rounded-0" required id="produit_id'+p+'"></select>' +
            '</td>'+
            '<td>'+
                '<input type="number" class="form-control rounded-0" min="0" step=\'0.01\' value=\'0.00\' required name="quantity[]" />'+
            '</td>'+
            '<td class="pt-6 text-end">'+
                '<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" onclick="deleteSub(this,0)">'+
                '<i class="las la-trash-alt fs-2x"></i>'+
            '</button>'+
            '</td>'+
        '</tr>'
    );
    var unit_id = "unit_id"+p;
    var produit_id = "produit_id"+p;
    unit_select(unit_id);
    produit_select(produit_id);
    var item_count = $("#item_count").val() - 0;
    $("#item_count").val(item_count + 1);
}


function unit_select($parent_id) {
    $.ajax({
        url:"/unit-select/",
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
                $('#'+$parent_id).append('<option value="'+data[$i].id+'">'+data[$i].name+'</option>');
            }
        },
        error: function(request, status, error) {
        },
    });
}


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


$("#EditRecetteForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('EditRecetteForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-add-item');
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

function deleteSub(el, id)
{
    var tr = $(el).parent().parent();
    Swal.fire({
        html: 'Voulez-vous supprimer cet élément de la fiche technique ?',
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
                deleteFicheItem(id)
            }
            $(el).closest("tr").remove();
            var count = 1;
            var item_count = $('.item_count').val();
            $('.item_count').val(item_count - count);

            Swal.fire(
                'Supprimer!',
                'Suppression éffectuée avec succés',
                'success'
            )
        }
    })
}

function deleteFicheItem(id){
    $.ajax({
        type:"POST",
        url: "delete-fiche-item",
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



