$("#form").on("submit",function(event){
    event.preventDefault();
    var submitButton;
    var form = document.getElementById('form');
    var action = form.getAttribute('action');
    submitButton = document.querySelector('#btn-submit');
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


            // Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
            //     window.location = redirectURL;
            // });
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
                    // window.location = redirectURL;

                    console.log(data);
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
