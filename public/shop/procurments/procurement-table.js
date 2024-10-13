var KTDatatablesAjaxServer = function() {

    var initDatatable = function () {
        var table = $('#ajax-datatable-procurement');
        const documentProcurementTitle = 'Liste commandes fournisseurs'
        datatable = $(table).DataTable({
            "language":{
                "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                "sInfo":           "Affichage de l'élt _START_ à _END_ sur _TOTAL_ éléments",
                "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "Afficher _MENU_ éléments",
                "sLoadingRecords": "Chargement...",
                "sProcessing":     "Traitement...",
                "sSearch":         "Rechercher :",
                "sZeroRecords":    "Aucun élément correspondant trouvé",
                "oPaginate": {
                	"sFirst":    "Première",
                	"sLast":     "Dernière",
                	"sNext":     "Suivante",
                	"sPrevious": "Précédente"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                },
                "select": {
                        "rows": {
                            "_": "%d lignes sélectionnées",
                            "0": "Aucune ligne sélectionnée",
                            "1": "1 ligne sélectionnée"
                        }
                }
            },
            searchDelay: 500,
            processing: true,
            serverSide: true,
            searching: false,
            info: false,
            order: [[5, 'desc']],
            ajax: {
                url: "/purchases/providers/",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
                {data: 'DT_RowIndex'},
				{data: 'reference'},
                {data: 'fournisseur'},
                {data: 'cost',
                    render: function ( data, type, row ) {
                        if ( data === null ) {
                            return '0'
                        }
                        var number = $.fn.dataTable.render.number(' '). display(data);
                        return number;
                    }
                },
                {data: 'procurment_status',
                    render: function ( data, type, row ) {
                        if (data == 0) {
                            return '<span class="ms-2 py-3 px-4 fs-7 badge badge-info fw-bold">En attente de validation</span>';
                        }
                        if (data == 1) {
                            return '<span class="ms-2 py-3 px-4 fs-7 badge badge-warning fw-bold">En attente de réception</span>';
                        }
                        if (data == 2) {
                            return '<span class="ms-2 py-3 px-4 fs-7 badge badge-success fw-bold">Livré</span>';
                        }
                        if (data == 3) {
                            return '<span class="ms-2 py-3 px-4 fs-7 badge badge-danger fw-bold">Annulé</span>';
                        }
                    },
                },
                {data: 'add_date',
                    render: function(data, type, full)
                    {
                        return moment(data).locale('fr').format('LLLL');
                    },
                },
                {data: 'auteur'},
				{data: 'action', name: 'action', orderable: false, responsivePriority: -1,  width: '100px'},
			],

            'drawCallback' :function(settings) { KTMenu.createInstances(); }
        });

        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
    };

  /*  form = document.getElementById('form');
    submitButton = document.getElementById('btn-refund-form');
    var validator;
    var handleForm = function (e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    note: {
                        validators: {
                            notEmpty: {
                                message: 'Le champ note est obligatoire.'
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

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    submitButton.disabled = true;

                    axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form))
                        .then(function (response) {
                            $('#modal-refund-procurement').modal("hide");
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
                                    var oTable = $('#ajax-datatable-order-storehouse').dataTable();
                                    oTable.fnDraw(false);
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
    }*/

	return {
		init: function() {
			initDatatable();
            /*handleForm();*/
		},
	};

}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesAjaxServer.init();
});


function functionConfirmOrder(id, url, datatable_id) {
    Swal.fire({
        text: "Voulez vous valider cette commande ?",
        icon: "info",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Confirmer!",
        cancelButtonText: "Annuler",
        customClass: {
            confirmButton: "btn fw-bold btn-success",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                method:"POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    console.log(res);
                    var oTable = $('#'+datatable_id).dataTable();
                    oTable.fnDraw(false);
                    Swal.fire({
                        text: "Votre commande a été valider avec succès.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-default"
                        }
                    });
                }
            });
        }

    });
}

function refundProcurementFunction(id, reference) {
    $('#modal-refund-procurement').modal('show');
    $('#modal-title').html('ANNULER LA COMMANDE N° '+reference);
    $("#procurement_id").val(id);
    $("#confirm_note").val("");
}

