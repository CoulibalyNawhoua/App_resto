
var KTUsersUpdateEmail = function () {

    const element = document.getElementById('kt_modal_update_email');
    const form = element.querySelector('#kt_modal_update_email_form');
    const modal = new bootstrap.Modal(element);
    var initUpdateEmail = () => {
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    email: {
						validators: {
							notEmpty: {
								message: 'Veuillez sasir l\'adresse email de l\ utilisateur'
							},
                            remote: {
                                url: '/check-email-exist/',
                                data: {
                                    type: 'email',
                                },
                                message: 'Cette adresse email est déjà utilisée',
                                method: 'GET',
                            },
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

        const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
        closeButton.addEventListener('click', e => {
            e.preventDefault();

            form.reset();
            modal.hide();
        });
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
                                console.log(response.data);
                                $('.address_email').html(response.data)
                                Swal.fire({
                                    text: "L\'adresse e-mail a été mis à jour",
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

    return {
        init: function () {
            initUpdateEmail();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdateEmail.init();
});
