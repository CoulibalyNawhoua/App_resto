
var KTAccountSettingsSigninMethods = function () {
    var handleChangePassword = function (e) {
        var validation;

        var form = document.getElementById('kt_signin_change_password');
        var submitButton = form.querySelector('#kt_password_submit');

        validation = FormValidation.formValidation(
            form,
            {
                fields: {
                    current_password: {
                        validators: {
                            notEmpty: {
                                message: 'Le mot de passe actuel est obligatoire.'
                            }
                        }
                    },

                    new_password: {
                        validators: {
                            notEmpty: {
                                message: 'Un nouveau mot de passe est obligatoire.'
                            }
                        }
                    },

                    new_confirm_password: {
                        validators: {
                            notEmpty: {
                                message: 'Confirmer le mot de passe est obligatoire.'
                            },
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="new_password"]').value;
                                },
                                message: 'Le nouveau mot de passe et sa confirmation ne sont pas les mêmes.'
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validation.validate().then(function (status) {
                if (status == 'Valid') {

                    submitButton.setAttribute('data-kt-indicator', 'on');

                    submitButton.disabled = true;

                    axios.post(form.getAttribute('action'), new FormData(form))
                        .then(function (response) {
                            Swal.fire({
                                text: "Votre mot de passe a été réinitialisé avec succès.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            });
                        })
                        .catch(function (error) {
                            let dataMessage = '';
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
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        })
                        .then(function () {
                            submitButton.removeAttribute('data-kt-indicator');

                            submitButton.disabled = false;
                        });

                }
               /* else {
                    Swal.fire({
                        text: "Désolé, il semble qu'il y ait des erreurs détectées, veuillez réessayer.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    });
                }*/
            });
        });
    }
    return {
        init: function () {
            handleChangePassword();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    KTAccountSettingsSigninMethods.init();
});
