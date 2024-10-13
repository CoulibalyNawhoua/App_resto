
var KTDatatablesPermissionAjaxServer = function() {

    var table ;
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
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'Tous'],
            ],
            searchDelay: 500,
            processing: true,
            serverSide: true,
            searching: false,
            info: false,
            order: [[2, 'desc']],
            ajax: {
                url: "permissions",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
				{data: 'DT_RowIndex'},
				{data: 'name'},
                {data: 'created_at',
                    render: function(data, type, full)
                    {
                        return moment(data).locale('fr').format('LLLL');
                    },
                },
				{data: 'action', name: 'action', orderable: false, responsivePriority: -1,  width: '50px'},
			],

            'drawCallback' :function(settings) { KTMenu.createInstances(); }
        });

        datatable.on('draw', function () {
            // handleDeleteRows();
            KTMenu.createInstances();
        });

        $('#export_print').on('click', function(e) {
			e.preventDefault();
			datatable.button(0).trigger();
		});
    };

    var exportButtons = () => {
        const documentTitle = 'Liste des permissions';
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3]
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3]
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


	return {
		init: function() {
            table = document.querySelector('#ajax-datatable-permission');

            if ( !table ) {
                return;
            }
            initDatatable();
            exportButtons();
		},
	};

}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesPermissionAjaxServer.init();
});


function deleteFunction(permission_id){

    Swal.fire({
        title: "Êtes-vous sûr?",
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Oui, supprimer!",
        cancelButtonText: "Non, annuler!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                method:"POST",
                url: "delete-permission",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: { permission_id: permission_id },
                dataType: 'json',
                success: function(res){
                    console.log(res);
                    var oTable = $('#kt_datatable_permission').dataTable();
                    oTable.fnDraw(false);
                    Swal.fire({
                        text: "Vous avez supprimé !.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, confirmation!",
                        customClass: {
                            confirmButton: "btn btn-danger",
                            cancelButton: "btn btn-default"
                        }
                    });
                }
            });
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Annuler",
                "Suppression Annulé",
                "error"
            )
        }
    });
}
