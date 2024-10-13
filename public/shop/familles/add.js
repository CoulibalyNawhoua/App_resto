var initForm = function() {
    var _handleForm = function () {
        var form = document.getElementById('form')
        var validation = FormValidation.formValidation(
            form,
            {
                fields: {
					nom_famille_produit: {
						validators: {
							notEmpty: {
								message: 'Veuillez sasir le nom famille'
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
                        var redirectURL = $('#form').attr('data-redirect')
                        var formData = new FormData(form);
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
                            error: function(error){
                                console.log(error);
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



var KTSignupGeneral = function () {
    var form;
    var submitButton;
    var validator;
    var handleForm = function (e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    nom_famille_produit: {
						validators: {
							notEmpty: {
								message: 'Veuillez sasir le nom famille'
							}
						}
					},
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            // Prevent button default action
            e.preventDefault();

            // Validate form
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    // Simulate ajax request
                    axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form))
                        .then(function (response) {
                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "You have successfully registered! Please check your email for verification.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    form.querySelector('[name="email"]').value = "";
                                    form.querySelector('[name="password"]').value = "";
                                    window.location.reload();
                                }
                            });
                        })
                        .catch(function (error) {
                            let dataMessage = error.response.data.message;
                            let dataErrors = error.response.data.errors;

                            for (const errorsKey in dataErrors) {
                                if (!dataErrors.hasOwnProperty(errorsKey)) continue;
                                dataMessage += "\r\n" + dataErrors[errorsKey];
                            }

                            if (error.response) {
                                Swal.fire({
                                    text: dataMessage,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        })
                        .then(function () {
                            // always executed
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
                        });
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    }

    return {
        init: function () {
            form = document.querySelector('#add_famille_form');
            submitButton = document.querySelector('#kt_add_famille_submit');
            handleForm();
        }
    };
}();
