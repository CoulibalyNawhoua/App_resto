"use strict";

// Class definition
var KTUsersUpdateDepot = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_depot');
    const form = element.querySelector('#kt_modal_update_depot_form');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdateDepot = () => {

        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    // 'entite_id': {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Veuillez sélectionner un entrepôt.'
					// 		}
					// 	}
					// },
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
            form.reset(); // Reset form
            modal.hide(); // Hide modal
            $("#entite_id").select2("destroy");
            $("#entite_id").select2();
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
                                $('.entrepot_user').html(response.data)
                                Swal.fire({
                                    text: "L'entrepôt de cet utilisateur a été mis à jour",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        modal.hide();
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
        // Public functions
        init: function () {
            initUpdateDepot();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdateDepot.init();
});



