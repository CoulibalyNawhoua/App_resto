<x-default-layout>

    <div class="card card-bordered mt-10">
        <div class="card-header">
            <h3 class="card-title">Fournisseurs</h3>
            <div class="card-toolbar">
                {{--  @can('ajouter_fournisseur')
                    <a href="javascript:;" onclick="addFunction()" class="btn btn-primary btn-sm hover-elevate-up">Nouveau fournisseur</a>
                @endcan  --}}
                <a href="javascript:;" onclick="addFunction()" class="btn btn-primary me-5 btn-sm hover-elevate-up">
                    <i class="ki-duotone ki-plus-circle fs-3">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    Nouveau fournisseur
                </a>
                <button type="button" class="btn btn-info btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>	Exporter
                </button>

                <div id="kt_datatable_example_export_menu" data-kt-menu="true" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4">

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="copy">
                            Copier dans le presse-papier
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="excel">
                            Exporter en excel
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="csv">
                            Exporter en CSV
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="pdf">
                            Exporter en PDF
                        </a>
                    </div>
                </div>
                <div id="kt_datatable_example_buttons" class="d-none"></div>
            </div>
        </div>
        <div class="card-body">
            <table id="ajax-datatable-fournisseurs" class="table table-rounded table-striped border gy-7 gs-7">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Téléphone</th>
                        <th>Date ajout</th>
                        <th>Créer par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <form id="form" method="POST" action="{{ route('fournisseurs.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="fournisseur_id" id="fournisseur_id">
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal-fournisseur">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title"></h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Nom fournisseur</label>
                            <input type="text" name="nom" id="nom_id" autocomplete="off" class="form-control" placeholder="Nom fournisseur" />
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Prenom fournisseur</label>
                            <input type="text" name="prenom" id="prenom_id" autocomplete="off" class="form-control" placeholder="Prenom fournisseur" />
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Numéro personnel</label>
                            <input type="text" autocomplete="off" name="telephone" id="telephone_id" class="form-control" placeholder="Téléphone fournisseur" />
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="form-label">Adresse </label>
                            <input type="text" autocomplete="off" id="localisation" name="localisation_id" class="form-control" placeholder="Localisation" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-add" class="btn btn-primary">
                            <span class="indicator-label">ENREGISTRER</span>
                            <span class="indicator-progress">Veuillez patienter.....
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-default-layout>
