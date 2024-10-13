var initForm = function() {
    var _handleForm = function () {
        var form = document.getElementById('form')
        var validation = FormValidation.formValidation(
            form,
            {
                fields: {
					nom_sous_famille: {
						validators: {
							notEmpty: {
								message: 'Veuillez sasir le nom sous famille'
							}
						}
					},
					famille_produit_id: {
						validators: {
							notEmpty: {
								message: 'Veuillez sélectionner la famille'
							}
						}
					},
				},
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            });

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();
                validation.validate().then(function(status) {
                    if (status == 'Valid') {
                        $("#btn_submit"). attr("disabled", true);
                        var action_url = $('#form').attr('action');
                        var formData = new FormData(form);
                        var redirectURL = $('#form').attr('data-redirect')
                        $.ajax({
                            type:'POST',
                            url: action_url,
                            data: formData,
                            cache:false,
                            contentType: false,
                            processData: false,
                            beforeSend:function(){
                                KTApp.blockPage({
                                    overlayColor: '#000000',
                                    state: 'danger',
                                    message: 'Veuillez patienter un instant...'
                                });
                            },
                            success: (data) => {
                                $("#btn_submit"). attr("disabled", false);
                                Swal.fire("Confirmation!", "Enregistrement effectué avec Succès", "success").then(function() {
                                    window.location = redirectURL;
                                });
                            },
                            error: function(data){
                                console.log(data);
                            },
                            complete: function() {
                                KTApp.unblockPage();
                            },
                        });
                    }
                });
            });
        };
    return {
        init: function() {
            _handleForm();
        },
    };
}();

jQuery(document).ready(function() {
    initForm.init();
});

