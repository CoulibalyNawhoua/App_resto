
$('#button-add-item').on('click', function(){
    functionAddUnit();
});

var p=1;
function functionAddUnit() {
    p++;
    $('#table-ajouter-item').append(
        '<tr class="border-bottom border-bottom-dashed" data-kt-element="item">'+
            '<td class="ps-0">'+
                '<select name="produits[]" onchange="selectUnitForGroupUnit(this);" class="form-select rounded-0 product_id" required id="produit_id'+p+'"></select>' +
            '<td>'+
                '<select name="unites[]" class="form-select rounded-0 unit_id" required id="unit_id'+p+'"></select>' +
            '</td>'+
            '<td>'+
                '<input type="number" class="form-control rounded-0" required name="quantity[]" />'+
            '</td>'+
            '<td class="pt-6 text-end">'+
                '<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" onclick="deleteSub(this,0)">'+
                    '<i class="las la-trash-alt fs-2x"></i>'+
                '</button>'+
            '</td>'+
        '</tr>'
    );
    // var unit_id = "unit_id"+p;
    var produit_id = "produit_id"+p;
    // unit_select(unit_id);
    produit_select(produit_id);
    var item_count = $("#item_count").val() - 0;
    $("#item_count").val(item_count + 1);

}

function deleteSub(el, id)
{
    $(el).parent().parent().remove();
    var item_count = $("#item_count").val() - 0;
    $("#item_count").val(item_count - 1);
}



$("#AddRecetteForm").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('AddRecetteForm');
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
