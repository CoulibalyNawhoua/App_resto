
var KTDatatablesAjaxServer = function() {
    var table;
    var datatable;
    var initDatatable = function () {

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
                // "oPaginate": {
                // 	"sFirst":    "",
                // 	"sLast":     "",
                // 	"sNext":     "",
                // 	"sPrevious": ""
                // },
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
            info: true,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'Tous'],
            ],
            order: [[0, 'asc']],
            ajax: {
                url: "categories",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
				{data: 'DT_RowIndex'},
                {data: 'nom_categorie'},
				{data: 'code_categorie'},
                {data: 'add_date',
                    render: function(data, type, full)
                    {
                        return moment(data).locale('fr').format('LLLL');
                    },
                },
                {data: 'created_by'},
				{data: 'action', name: 'action', orderable: false, responsivePriority: -1,  width: '50px'},
			],

            'drawCallback' :function(settings) { KTMenu.createInstances(); }
        });

        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
    };

    var exportButtons = () => {
        const documentTitle = 'Liste des catégories';
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 3, 4]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 3, 4]
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 3, 4]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 3, 4]
                    }
                }
            ]
        }).container().appendTo($('#kt_datatable_example_buttons'));

        // Hook dropdown menu click event to datatable export buttons
        const exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu [data-kt-export]');
        exportButtons.forEach(exportButton => {
            exportButton.addEventListener('click', e => {
                e.preventDefault();

                // Get clicked export value
                const exportValue = e.target.getAttribute('data-kt-export');
                const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

                // Trigger click event on hidden datatable export buttons
                target.click();
            });
        });
    }

    var form;
    var submitButton;
    var validator;
    var handleForm = function (e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    nom_categorie: {
						validators: {
							notEmpty: {
								message: 'Le champ nom catégorie est obligatoire.'
							}
						}
					},
					code_categorie: {
						validators: {
							notEmpty: {
								message: 'Le champ code catégorie est obligatoire.'
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
                            $('#modal-categorie').modal("hide");
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
                                    var oTable = $('#ajax-datatable-categorie').dataTable();
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
    }

	return {
		init: function() {
            table = document.querySelector('#ajax-datatable-categorie');

            if ( !table ) {
                return;
            }
            initDatatable();
            exportButtons();
            form = document.querySelector('#form');
            submitButton = document.querySelector('#btn-add');
            handleForm();
		},
	};

}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesAjaxServer.init();
});




function addFunction() {
    $('#form').trigger('reset');
    $('#modal-categorie').modal('show');
    $('#modal-title').html('NOUVELLE CATEGORIE');
    $('#categorie_id').val('');
    document.getElementById("code_categorie_id").readOnly = false;
}



function editFunction(id){
    $.ajax({
        type:"POST",
        url: "categorie-view",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data: { id: id },
        dataType: 'json',
        success: function(resp){
            console.log(resp);
            $('#modal-categorie').modal('show');
            $('#modal-title').html('MODIFIER CATEGORIE');
            $('#categorie_id').val(resp.id);
            $('#nom_categorie_id').val(resp.nom_categorie);
            $('#code_categorie_id').val(resp.code_categorie);
            document.getElementById("code_categorie_id").readOnly = true;
        }
    });
}