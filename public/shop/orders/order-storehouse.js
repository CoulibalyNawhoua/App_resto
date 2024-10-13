var KTDatatablesAjaxServer = function() {
    var initDatatable = function () {
        var table = $('#ajax-datatable-order-storehouse');
        const documentProcurementTitle = 'Commandes entrepôts'
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
            order: [[4, 'desc']],
            buttons: [
                {
                    text: 'Imprimer',
                    extend:'print',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0]
                    }
                },
                {
                    text: 'excel',
                    extend:'excelHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0]
                    }
                },
                {
                    text: 'PDF',
                    extend:'pdfHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0]
                    }
                },
                {
                    text: 'CSV',
                    extend:'csvHtml5',
                    title: documentProcurementTitle,
                    exportOptions: {
                        columns: [ 0]
                    }
                },
            ],
            ajax: {
                url: "/orders/deposit/",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
                {data: 'DT_RowIndex'},
				{data: 'reference'},
                {data: null,
                    render: function ( data, type, row ) {

                        return data.entite.name
                    }
                },
                {data: 'order_status',
                    render: function ( data, type, row ) {
                        if (data == 0) {
                            return '<span class="ms-2 badge py-3 px-4 fs-7 badge-light-primary fw-bold">Créer</span>';
                        }
                        if (data == 1) {
                            return '<span class="ms-2 badge py-3 px-4 fs-7 badge-light-info fw-bold">En attente de validation</span>';
                        }
                        if (data == 2) {
                            return '<span class="ms-2 badge py-3 px-4 fs-7 badge-light-success fw-bold">En cours</span>';
                        }
                        if (data == 3) {
                            return '<span class="ms-2 badge py-3 px-4 fs-7 badge-light-danger fw-bold">Annuler</span>';
                        }
                        if (data == 4) {
                            return '<span class="ms-2 badge py-3 px-4 fs-7 badge-light-success fw-bold">Clôturée</span>';
                        }
                    },
                },
                {data: 'add_date',
                    render: function(data, type, full)
                    {
                        return moment(data).locale('fr').format('LLLL');
                    },
                },
                {data: null,
                    render: function ( data, type, row ) {

                        return data.auteur.first_name+' '+data.auteur.last_name;
                    }
                },
                /*{data: null,
                    render: function ( data, type, row ) {
                        return '<span class="badge badge-circle badge-outline me-5 badge-warning">'+data.delivery_pending+'</span>'+
                                '<span class="badge badge-circle  badge-outline me-5 badge-danger">'+data.delivery_cancel+'</span>'+
                                '<span class="badge badge-circle  badge-outline badge-success">'+data.shipping_progress+'</span>';
                    }
                },*/
				{data: 'action', name: 'action', orderable: false, responsivePriority: -1,  width: '100px'},
			],

            'drawCallback' :function(settings) { KTMenu.createInstances(); }
        });

        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
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



