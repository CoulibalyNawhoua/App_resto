var KTDatatablesAjaxServer = function() {

    var initDatatable = function () {
        var table = $('#ajax-datatable-order-received');
        const documentProcurementTitle = 'Liste commandes reçues'
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
            order: [[4, 'desc']],
            buttons: [
                {
                    text: 'Imprimer',
                    extend:'print',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4]
                    }
                },
                {
                    text: 'excel',
                    extend:'excelHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4]
                    }
                },
                {
                    text: 'PDF',
                    extend:'pdfHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4]
                    }
                },
                {
                    text: 'CSV',
                    extend:'csvHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4]
                    }
                },
            ],
            ajax: {
                url: "/orders/storehouse/received/",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
				{data: 'reference'},
                {data: 'entrepot'},
                {data: 'order_status'},
                {data: 'delivery_status'},
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

        // $('#export_print').on('click', function(e) {
		// 	e.preventDefault();
		// 	datatable.button(0).trigger();
		// });

        // $('#export_excel').on('click', function(e) {
		// 	e.preventDefault();
		// 	datatable.button(1).trigger();
		// });

        // $('#export_csv').on('click', function(e) {
		// 	e.preventDefault();
		// 	datatable.button(2).trigger();
		// });

        // $('#export_pdf').on('click', function(e) {
		// 	e.preventDefault();
		// 	datatable.button(3).trigger();
		// });
    };

	return {
		init: function() {
			initDatatable();
		},
	};

}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesAjaxServer.init();
});


