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
            responsive: true,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'Tous'],
            ],
            order: [[9, 'desc']],
            ajax: {
                url: "/products/stock-adjustment/",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'reference'},
                {data: 'depot_stockage'},
                {data: 'nom_produit'},
                {data: 'product_unit'},
                // {data: 'before_quantity'},
                {data: null,
                    render: function ( data, type, row ) {

                        if ( data.before_quantity === null ) {
                            return '0'
                        }
                        var before_quantity = $.fn.dataTable.render.number(' '). display(data.before_quantity);

                        return before_quantity+' '+data.product_unit
                    },
                    orderable: false
                },
                // {data: 'quantity'},
                {data: null,
                    render: function ( data, type, row ) {

                        if ( data.quantity === null ) {
                            return '0'
                        }

                        var quantity = $.fn.dataTable.render.number(' '). display(data.quantity);

                        return quantity+' '+data.unite_ajustement
                    },
                    orderable: false
                },
                // {data: 'after_quantity'},
                {data: null,
                    render: function ( data, type, row ) {

                        if ( data.after_quantity === null ) {
                            return '0'
                        }

                        var after_quantity = $.fn.dataTable.render.number(' '). display(data.after_quantity);

                        return after_quantity+' '+data.product_unit
                    },
                    orderable: false
                },
                {data: null,
                    render: function ( data, type, row ) {

                        if ( data.types === 'sub' ) {
                            return '<span class="ms-2 badge badge-danger fw-bold">Supprimer</span>'
                        }
                        if ( data.types === 'add' ) {
                            return '<span class="ms-2 badge badge-primary fw-bold">Ajouter</span>'
                        }

                        if ( data.types === 'init' ) {
                            return '<span class="ms-2 badge badge-primary fw-bold">Initialisation</span>'
                        }

                    },
                    orderable: false
                },
                // {data: 'type_operation'},
                /*{data: 'action_stock'},*/
                {data: 'add_date',
                    render: function(data, type, full)
                    {
                        return moment(data).locale('fr').format('LLLL');
                    },

                },
                {data: 'auteur'},
                // {data: 'action', name: 'action', orderable: false, responsivePriority: -1,  width: '100px'},
            ],

            'drawCallback' :function(settings) { KTMenu.createInstances(); }

        });

        datatable.on('draw', function () {
            KTMenu.createInstances();
        });

    };

    var exportButtons = () => {
        var depot_stockage = document.getElementById("depot_stockage").innerHTML
        const documentTitle = 'Liste des ajustements '+ depot_stockage;
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 8, 9, 10]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 8, 9, 10]
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 8, 9, 10]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 8, 9, 10]
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
            table = document.querySelector('#ajax-datatable-ajustment');

            if ( !table ) {
                return;
            }
            initDatatable();
            exportButtons();
        },
    };

}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesAjaxServer.init();
});


