
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
            '<input type="hidden"  name="product_unit_id[]" value="">'+
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

        deleteUnitProduct(id);
    }
    $(el).parent().parent().remove();

    var count_unit_product = $("#produit_a_une_unite").val() - 0;
    $("#produit_a_une_unite").val(count_unit_product - 1);
}


function deleteUnitProduct(id){
    $.ajax({
        type:"POST",
        url: "delete-unit-product",
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


$("#EditProductForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('EditProductForm');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-edit-product');
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

