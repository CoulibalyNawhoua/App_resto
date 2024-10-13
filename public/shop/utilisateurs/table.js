var KTDatatablesUsersAjaxServer = function() {

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
            order: [[0, 'desc']],
            ajax: {
                url: "users",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
				{data: 'DT_RowIndex'},
                {data: 'first_name'},
				{data: 'last_name'},
                {data: 'active',
                render: function ( data, type, row ) {
                        if ( data == 1 ) {
                            return '<span class="badge py-3 px-4 fs-7 badge-light-success">Actif</span>'

                        }
                        return '<span class="badge py-3 px-4 fs-7 badge-light-danger">Inactif</span>';
                    }
                },
                {data: 'role'},
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
            KTMenu.createInstances();
        });
    };

    var exportButtons = () => {
        const documentTitle = 'Liste des roles';
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
                        columns: [ 1, 2, 3, 4, 5]
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
                        columns: [ 1, 2, 3, 4, 5]
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
            table = document.querySelector('#ajax-datatable-users');

            if ( !table ) {
                return;
            }
            initDatatable();
            exportButtons();
		},
	};

}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesUsersAjaxServer.init();
});



// function desactiverCompte(user_id){

//     Swal.fire({
//         title: "Êtes-vous sûr?",
//         text: "Voulez-vous désactiver le compte de cet utilisateur?",
//         icon: "info",
//         showCancelButton: true,
//         confirmButtonText: "Oui, supprimer!",
//         cancelButtonText: "Non, annuler!",
//         reverseButtons: true
//     }).then(function(result) {
//         if (result.value) {
//             $.ajax({
//                 method:"POST",
//                 url: "disabled-account",
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },
//                 data: { user_id: user_id },
//                 dataType: 'json',
//                 success: function(res){
//                     console.log(res);
//                     var oTable = $('#utilisateur_datatable').dataTable();
//                     oTable.fnDraw(false);
//                     Swal.fire({
//                         text: "Vous avez supprimé !.",
//                         icon: "success",
//                         buttonsStyling: !1,
//                         confirmButtonText: "Ok, confirmation!",
//                         customClass: {
//                             confirmButton: "btn btn-primary",
//                             cancelButton: "btn btn-default"
//                         }
//                     });
//                 }
//             });
//         } else if (result.dismiss === "cancel") {
//             Swal.fire(
//                 "Annuler",
//                 "Suppression Annulé",
//                 "error"
//             )
//         }
//     });
// }


// function activateAccount(user_id){

//     Swal.fire({
//         title: "Êtes-vous sûr?",
//         text: "Voulez-vous activer le compte de cet utilisateur?",
//         icon: "info",
//         showCancelButton: true,
//         confirmButtonText: "Oui, supprimer!",
//         cancelButtonText: "Non, annuler!",
//         reverseButtons: true
//     }).then(function(result) {
//         if (result.value) {
//             $.ajax({
//                 method:"POST",
//                 url: "activate-account",
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },
//                 data: { user_id: user_id },
//                 dataType: 'json',
//                 success: function(res){
//                     console.log(res);
//                     var oTable = $('#utilisateur_datatable').dataTable();
//                     oTable.fnDraw(false);
//                     Swal.fire({
//                         text: "Vous avez supprimé !.",
//                         icon: "success",
//                         buttonsStyling: !1,
//                         confirmButtonText: "Ok, confirmation!",
//                         customClass: {
//                             confirmButton: "btn btn-primary",
//                             cancelButton: "btn btn-default"
//                         }
//                     });
//                 }
//             });
//         } else if (result.dismiss === "cancel") {
//             Swal.fire(
//                 "Annuler",
//                 "Suppression Annulé",
//                 "error"
//             )
//         }
//     });
// }


// function deleteFunction(id){

//     Swal.fire({
//         title: "Êtes-vous sûr?",
//         text: "Vous ne pourrez pas revenir en arrière!",
//         icon: "error",
//         showCancelButton: true,
//         confirmButtonText: "Oui",
//         cancelButtonText: "Non",
//         reverseButtons: true
//     }).then(function(result) {
//         if (result.value) {
//             $.ajax({
//                 method:"POST",
//                 url: "delete-user",
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },
//                 data: { id: id },
//                 dataType: 'json',
//                 success: function(res){
//                     console.log(res);
//                     var oTable = $('#ajax-datatable-users').dataTable();
//                     oTable.fnDraw(false);
//                     Swal.fire({
//                         text: "Vous avez supprimé !.",
//                         icon: "success",
//                         buttonsStyling: !1,
//                         confirmButtonText: "Ok",
//                         customClass: {
//                             confirmButton: "btn btn-primary",
//                             cancelButton: "btn btn-default"
//                         }
//                     });
//                 }
//             });
//         } else if (result.dismiss === "cancel") {
//             Swal.fire(
//                 "Annuler",
//                 "Suppression Annulé",
//                 "error"
//             )
//         }
//     });
// }

