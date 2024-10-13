
$('#btn-add-item').on('click', function(){
    var count_unit_product = $("#produit_a_une_unite").val() - 0;
    if (count_unit_product < 2) {
        functionAddUnit();
    }
});

var p=1;
function functionAddUnit() {
    p++;
    $('#table-ajouter-tarif').append(
        '<tr class="border-bottom border-bottom-dashed" data-kt-element="item">'+
            '<td class="ps-0">'+
            '<select name="unites[]" class="form-select rounded-0" required id="unit_id'+p+'"></select>' +
            '<td>'+
                '<input type="number" class="form-control rounded-0" required name="pcb[]" />'+
            '</td>'+
            '<td>'+
                '<input type="number" class="form-control rounded-0" required name="price[]" />'+
            '</td>'+
            '<td class="pt-6 text-end">'+
                '<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" onclick="deleteSub(this,0)">'+
                '<i class="las la-trash-alt fs-2x"></i>'+
                '</button>'+
            '</td>'+
        '</tr>'
    );
    var unit_id = "unit_id"+p;
    unit_select(unit_id);
    var count_unit_product = $("#produit_a_une_unite").val() - 0;
    $("#produit_a_une_unite").val(count_unit_product + 1);
}

function deleteSub(el, id)
{
    if (Number(id) > 0) {
        $(el).parents('form').append('<input type="hidden" name="delete_sub[]" value="' + id + '" />');
    }
    $(el).parent().parent().remove();

    var count_unit_product = $("#produit_a_une_unite").val() - 0;
    $("#produit_a_une_unite").val(count_unit_product - 1);
}

function unit_select($parent_id) {
    $.ajax({
            url:"/unit-group-select/",
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


$("#AddProductForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('AddProductForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-add-product');
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




