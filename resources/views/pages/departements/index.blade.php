<x-default-layout>
    <div class="card card-bordered mt-10">
        <div class="card-header">
            <h3 class="card-title">Departements</h3>
            <div class="card-toolbar">
                <a href="javascript:;" onclick="addFunction()" class="btn btn-primary me-5 btn-sm hover-elevate-up">Nouveau département</a>
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
            <div class="table-responsive">
                <table id="ajax-datatable-departement" class="table align-middle table-row-dashed fs-6 gy-5 border rounded ">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Id</th>
                            <th>Libélle</th>
                            <th>Code</th>
                            <th>Date ajout</th>
                            <th>Auteur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    <form id="form" method="POST" action="{{ route('departements.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="departement_id" id="departement_id">
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal-departement">
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
                            <label class="required form-label">Libellé</label>
                            <input type="text" name="nom_departement" id="nom_departement_id"  class="form-control mb-2">
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Code</label>
                            <input type="text" name="code_departement" id="code_departement_id"  class="form-control mb-2">
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
