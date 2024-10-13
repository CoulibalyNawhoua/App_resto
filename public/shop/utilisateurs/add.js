var initForm = function() {
    var form;
    var submitButton;
    var validator;

    const strongPassword = function () {
        return {
            validate: function (input) {
                const value = input.value;
                if (value === '') {
                    return {
                        valid: true,
                    };
                }
                if (value.length < 8) {
                    return {
                        valid: false,
                        message: 'Le mot de passe doit comporter plus de 8 caractères',
                    };
                }

                if (value === value.toLowerCase()) {
                    return {
                        valid: false,
                        message: 'Le mot de passe doit contenir au moins un caractère majuscule',
                    };
                }

                if (value === value.toUpperCase()) {
                    return {
                        valid: false,
                        message: 'Le mot de passe doit contenir au moins un caractère minuscule',
                    };
                }

                if (value.search(/[0-9]/) < 0) {
                    return {
                        valid: false,
                        message: 'Le mot de passe doit contenir au moins un chiffre',
                    };
                }

                return {
                    valid: true,
                };
            },
        };
    };

    var handleForm = function (e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    first_name: {
						validators: {
							notEmpty: {
								message: 'Le champ nom est obligatoire.'
							}
						}
					},
					last_name: {
						validators: {
							notEmpty: {
								message: 'Le champ prénom est obligatoire.'
							}
						}
					},
                    // user_name: {
					// 	validators: {
                    //         remote: {
                    //             url: '/check-username-exist/',
                    //             data: {
                    //                 type: 'user_name',
                    //             },
                    //             message: 'Cette nom d\'utilisateur est déjà utilisé.',
                    //             method: 'GET',
                    //         },
					// 	}
					// },
                    email: {
						validators: {
							notEmpty: {
								message: 'Le champ adresse email est obligatoire.'
							},
                            remote: {
                                url: '/check-email-exist/',
                                data: {
                                    type: 'email',
                                },
                                message: 'Cette adresse email est déjà utilisé.',
                                method: 'GET',
                            },
						}
					},
                    password: {
						validators: {
							notEmpty: {
								message: 'Veuillez sasir le mot de passe de l\ utilisateur'
							}
						}
					},
                    password_confirmation: {
                        validators: {
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'Le mot de passe et sa confirmation ne sont pas les mêmes',
                            },
                        },
                    },
                    'roles[]': {
						validators: {
							notEmpty: {
								message: 'Veuillez sélectionner un role'
							}
						}
					},
                    // depot_id: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Veuillez sélectionner un dépôt d\'affectation'
					// 		}
					// 	}
					// },
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
            }).registerValidator('checkPassword', strongPassword);

            form.querySelector('[name="password"]').addEventListener('input', function () {
                validator.revalidateField('password_confirmation');
            });

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    submitButton.disabled = true;

                    axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form))
                        .then(function (response) {
                            // $('#kt_modal_add_user').modal("hide");
                            Swal.fire({
                                text: "Enregistrement effectué avec succès",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    var redirectURL = $('#addUserForm').attr('data-redirect')
                                    window.location = redirectURL;
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
            });
        });
    }
    return {
        init: function() {
            form = document.querySelector('#addUserForm');
            submitButton = document.querySelector('#btn_add_user_form');
            handleForm();
        },
    };
}();



KTUtil.onDOMContentLoaded(function () {
    initForm.init();
});

