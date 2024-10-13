var KTDatatablesAjaxServer = function() {

    var initDatatable = function () {
        var table = $('#ajax-datatable-procurement-receipt');
        const documentProcurementTitle = 'Réceptions commandes'
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
            order: [[6, 'desc']],
            buttons: [
                {
                    text: 'Imprimer',
                    extend:'print',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    text: 'excel',
                    extend:'excelHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    text: 'PDF',
                    extend:'pdfHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    text: 'CSV',
                    extend:'csvHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
            ],
            ajax: {
                url: "/purchases/providers/receipt/",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
				{data: 'DT_RowIndex'},
                {data: 'reception_date',
                    render: function(data, type, full)
                    {
                        return moment(data).locale('fr').format('LLLL');
                    },
                },
                {data: 'reception_ref'},
                {data: 'fournisseur'},
                {data: 'procurement_ref'},
                {data: 'total_receipt_price',
                    render: function ( data, type, row ) {
                        if ( data === null ) {
                            return '0'
                        }
                        var number = $.fn.dataTable.render.number(' '). display(data);
                        return number;
                    }
                },
                /*{data: 'receipt_status',
                    render: function ( data, type, row ) {
                        if (data == 0) {
                            return '<span class="ms-2 badge py-3 px-4 fs-7 badge-primary fw-bold">Annuler</span>';
                        }
                        if (data == 1) {
                            return '<span class="ms-2 badge py-3 px-4 fs-7 badge-success fw-bold">En cours</span>';
                        }
                    },
                },*/
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

