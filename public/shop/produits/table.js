
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
            info: true,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'Tous'],
            ],
            order: [[4, 'desc']],
            ajax: {
                url: "produits",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
				{data: 'DT_RowIndex'},
                // {data: 'famille'},
                // {data: 'sous_famille'},
                {data: 'nom_categorie'},
                {data: 'nom_produit'},
                {data: 'unite'},
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
    }

    // Hook export buttons
    var exportButtons = () => {
        const documentTitle = 'Liste des produits';
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6]
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

    // var form;
    // var submitButton;
    // var validator;
    // var handleForm = function (e) {
    //     validator = FormValidation.formValidation(
    //         form,
    //         {
    //             fields: {
    //                 nom_produit: {
	// 					validators: {
	// 						notEmpty: {
	// 							message: 'Le champ désignation est obligatoire.'
	// 						}
	// 					}
	// 				},
    //                 // sous_famille_id: {
	// 				// 	validators: {
	// 				// 		notEmpty: {
	// 				// 			message: 'Veuillez sélectionner une sous famille.'
	// 				// 		}
	// 				// 	}
	// 				// },
    //                 categorie_id: {
	// 					validators: {
	// 						notEmpty: {
	// 							message: 'Veuillez sélectionner une catégorie.'
	// 						}
	// 					}
	// 				},
    //                 unite_id: {
	// 					validators: {
	// 						notEmpty: {
	// 							message: 'Veuillez sélectionner une unité de gestion.'
	// 						}
	// 					}
	// 				},
    //                 prix_achat: {
	// 					validators: {
    //                         digits: {
    //                             message: 'Veuillez saisir un montant valide svp.',
    //                         },
	// 					}
	// 				},
    //             },
    //             plugins: {
    //                 trigger: new FormValidation.plugins.Trigger({
    //                     event: {
    //                         password: false
    //                     }
    //                 }),
    //                 bootstrap: new FormValidation.plugins.Bootstrap5({
    //                     rowSelector: '.fv-row',
    //                     eleInvalidClass: '',
    //                     eleValidClass: ''
    //                 })
    //             }
    //         }
    //     );

    //     submitButton.addEventListener('click', function (e) {
    //         e.preventDefault();
    //         validator.validate().then(function (status) {
    //             if (status === 'Valid') {
    //                 submitButton.setAttribute('data-kt-indicator', 'on');

    //                 submitButton.disabled = true;

    //                 axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form))
    //                     .then(function (response) {
    //                         $('#modal-produit').modal("hide");
    //                         Swal.fire({
    //                             text: "Enregistrement effectué avec succès",
    //                             icon: "success",
    //                             buttonsStyling: false,
    //                             confirmButtonText: "OK",
    //                             customClass: {
    //                                 confirmButton: "btn btn-primary"
    //                             }
    //                         }).then(function (result) {
    //                             if (result.isConfirmed) {
    //                                 var oTable = $('#ajax-datatable-produit').dataTable();
    //                                 oTable.fnDraw(false);
    //                             }
    //                         });
    //                     })
    //                     .catch(function (error) {
    //                         let dataMessage = error.response.data.message;
    //                         let dataErrors = error.response.data.errors;

    //                         for (const errorsKey in dataErrors) {
    //                             if (!dataErrors.hasOwnProperty(errorsKey)) continue;
    //                             dataMessage += "\r\n" + dataErrors[errorsKey];
    //                         }

    //                         if (error.response) {
    //                             Swal.fire({
    //                                 text: dataMessage,
    //                                 icon: "error",
    //                                 buttonsStyling: false,
    //                                 confirmButtonText: "OK",
    //                                 customClass: {
    //                                     confirmButton: "btn btn-primary"
    //                                 }
    //                             });
    //                         }
    //                     })
    //                     .then(function () {
    //                         submitButton.removeAttribute('data-kt-indicator');
    //                         submitButton.disabled = false;
    //                     });
    //             }
    //         });
    //     });
    // }

	return {
		init: function() {
            table = document.querySelector('#ajax-datatable-produit');

            if ( !table ) {
                return;
            }
            initDatatable();
            exportButtons();
            // form = document.querySelector('#form');
            // submitButton = document.querySelector('#btn-add');
            // handleForm();

		},
	};

}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesAjaxServer.init();
});


// function addFunction() {
//     $('#form').trigger('reset');
//     $('#modal-produit').modal('show');
//     $('#modal-title').html('NOUVEAU PRODUIT');
//     $("#produit_id").val('');
//     $("#unite_id").select2("destroy");
//     $("#unite_id").select2();
//     $("#categorie_id").select2("destroy");
//     $("#categorie_id").select2();
//     $("#sous_famille_id").select2("destroy");
//     $("#sous_famille_id").select2();
// }



// function editFunction(id){
//     $.ajax({
//         type:"POST",
//         url: "produit-view",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//         data: { id: id },
//         dataType: 'json',
//         success: function(resp){
//             console.log(resp);
//             $('#modal-produit').modal('show');
//             $('#modal-title').html('MODIFIER  PRODUIT');
//             $('#produit_id').val(resp.id);
//             $('#nom_produit_id').val(resp.nom_produit);
//             $('#reference_produit_id').val(resp.reference_produit);
//             $('#prix_achat_id').val(resp.prix_achat);
//             $('#unite_id').val(resp.unites_id);
//             $('#unite_id').trigger('change');
//             $('#categorie_id').val(resp.categories_id );
//             $('#categorie_id').trigger('change');
//             $('#sous_famille_id').val(resp.sous_familles_id );
//             $('#sous_famille_id').trigger('change');
//         }
//     });
// }
