
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
            order: [[0, 'asc']],
            ajax: {
                url: "conversions",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
				{data: 'id'},
                {data: 'unite_depart.name'},
                {data: 'unite_arrivee.name'},
                // {data: 'operation'},
                {data: 'value'},
				{data: 'action', name: 'action', orderable: false, responsivePriority: -1,  width: '50px'},
			],

            'drawCallback' :function(settings) { KTMenu.createInstances(); }
        });

        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
    };

    var exportButtons = () => {
        const documentTitle = 'Liste des conversions';
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 0, 1]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 0, 1]
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 0, 1]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [ 0, 1]
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
                    unite_depart_id: {
						validators: {
							notEmpty: {
								message: 'Le champ est obligatoire.'
							}
						}
					},
                    unite_arrive_id: {
						validators: {
							notEmpty: {
								message: 'Le champ est obligatoire.'
							}
						}
					},

                    // operation: {
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Le champ est obligatoire.'
					// 		}
					// 	}
					// },

                    value: {
						validators: {
							notEmpty: {
								message: 'Le champ est obligatoire.'
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
                            $('#modal-conversion').modal("hide");
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
                                    var oTable = $('#ajax-datatable-conversion').dataTable();
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
            table = document.querySelector('#ajax-datatable-conversion');

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
    $('#modal-conversion').modal('show');
    $('#modal-title').html('NOUVEAU');
    $("#conversion_id").val('');
    $("#unite_depart_id").select2("destroy");
    $("#unite_depart_id").select2();
    $('#conversion_id').val('');
    // $("#unite_arrive_id").select2("destroy");
    // $("#unite_arrive_id").select2();
    $('#unite_arrive_id').empty().append('<option selected="selected" value="">Aucun</option>');
    $('#unite_arrive_id').trigger('change');
}


function editFunction(id){

    var id_edite="";

    $.ajax({
        type:"POST",
        url: "/conversion-view/",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data: { id: id },
        dataType: 'json',
        success: function(resp){
            console.log(resp);
            $('#modal-conversion').modal('show');
            $('#modal-title').html('MODIFIER');
            $('#conversion_id').val(resp.id);
            $('#operation_id').val(resp.operation);
            $('#value_id').val(resp.value);
            $('#unite_depart_id').val(resp.unite_depart_id);
            $('#unite_depart_id').trigger('change');
            $('#unite_arrive_id').val(resp.unite_arrivee_id);
            $('#unite_arrive_id').trigger('change');
            SelectUnitGroupUnit(id_edite, 'unite_arrive_id', resp.unite_depart_id, resp.unite_arrivee_id)
        }
    });
}



function SelectUnitGroupUnit($id_select_parent, $id_select_enfant, cat_id=null, valeur_selection=null ){
    if(null==cat_id){
        var id_parent=document.getElementById($id_select_parent);
        var cat_id =id_parent.options[id_parent.selectedIndex].value;
    }
    $.ajax({
        url:"/select-unit-group-unit/",
        type:"POST",
        data: {
            id : cat_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function (data) {

            console.log(data);

            $('#'+$id_select_enfant).empty();
            $('#'+$id_select_enfant).select2("val", "");
            if (data.length==0){
                $('#'+$id_select_enfant).append('<option value="">Aucun(e)</option>');
                $('#'+$id_select_enfant).select2("val", "");
            }else{
                $('#'+$id_select_enfant).empty().append('<option value="">Aucun(e)</option>');
            }
            for ($i=0; $i<data.length;$i++){
            $('#'+$id_select_enfant).append('<option value="'+data[$i].id+'">'+data[$i].name+'</option>');
            if (valeur_selection){
                $('select[id='+$id_select_enfant +'] option[value='+valeur_selection+']').attr('selected',true);
                }
            $('#'+$id_select_enfant).select2("val", "");
            }
        },
        error: function(request, status, error) {
        },
    });
}
