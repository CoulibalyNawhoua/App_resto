
var KTUsersUpdatePassword = function () {
    const element = document.getElementById('kt_modal_update_password');
    const form = element.querySelector('#kt_modal_update_password_form');
    const modal = new bootstrap.Modal(element);

    var initUpdatePassword = () => {

        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    // 'current_password': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Current password is required'
                    //         }
                    //     }
                    // },
                    'new_password': {
                        validators: {
                            notEmpty: {
                                message: 'Le mot de passe est est obligatoire'
                            },
                            callback: {
                                message: 'Veuillez entrer un mot de passe valide',
                                callback: function (input) {
                                    if (input.value.length > 0) {
                                        return validatePassword();
                                    }
                                }
                            }
                        }
                    },
                    'confirm_password': {
                        validators: {
                            notEmpty: {
                                message: 'Le mot de passe de confirmation est obligatoire'
                            },
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="new_password"]').value;
                                },
                                message: 'Le mot de passe et sa confirmation ne sont pas les mêmes'
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

        const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        setTimeout(function () {
                            axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form) ,{
                                '_method': 'PUT',
                            })
                            .then(function (response) {
                                Swal.fire({
                                    text: "Le mot de passe a été mis à jour",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        modal.hide();
                                        form.reset();
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

                        }, 2000);
                    }
                });
            }
        });
    }

    const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
    closeButton.addEventListener('click', e => {
        e.preventDefault();
        form.reset();
        modal.hide();
    });

    return {
        // Public functions
        init: function () {
            initUpdatePassword();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdatePassword.init();
});
