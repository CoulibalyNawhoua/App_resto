


var KTDatatablesAjaxServer = function() {

    var table;
    var datatable;
    var initDatatable = function () {
        const documentTitle = 'Motfifs gaspillages'
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
            order: [[3, 'desc']],
            ajax: {
                url: "/motifs-gaspillages/",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                {data: 'DT_RowIndex'},
                // {data: 'type_operation'},
                {data: 'libelle'},
               /* {data: 'action_stock',},*/
                {data: 'add_date',
                    render: function(data, type, full)
                    {
                        return moment(data).locale('fr').format('LLLL');
                    },
                },
                {data: 'auteur'},
                {data: 'action', name: 'action', orderable: false, responsivePriority: -1,  width: '50px'},
            ],

            'drawCallback' :function(settings) { KTMenu.createInstances(); }
        });

        datatable.on('draw', function () {
            KTMenu.createInstances();
        });

    };

    var exportButtons = () => {
        const documentTitle = 'Motfifs gaspillages';
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [  1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [  1, 2, 3, 4, 5]
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
                    libelle: {
                        validators: {
                            notEmpty: {
                                message: 'Le champ libellé est obligatoire.'
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
                            $('#modal-motif-gaspillage').modal("hide");
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
                                    var oTable = $('#ajax-datatable-motif-gaspillage').dataTable();
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
            table = document.querySelector('#ajax-datatable-motif-gaspillage');

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
    $('#modal-motif-gaspillage').modal('show');
    $('#modal-title').html('NOUVEAU MOTIF');
    $("#motif_gaspillage_id").val('');
}



function editFunction(id){
    $.ajax({
        type:"POST",
        url: "/motif-gaspillage-view/",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: id },
        dataType: 'json',
        success: function(resp){
            $('#modal-motif-gaspillage').modal('show');
            $('#modal-title').html('MODIFIER MOTIF');
            $('#motif_gaspillage_id').val(resp.id);
            $('#libelle_id').val(resp.libelle);
        }
    });
}
