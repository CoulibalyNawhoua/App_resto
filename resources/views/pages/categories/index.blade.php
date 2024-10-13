<x-default-layout>
    <div class="card card-bordered mt-10">
        <div class="card-header">
            <h3 class="card-title">Catégories</h3>
            <div class="card-toolbar">
                <a href="javascript:;" onclick="addFunction()" class="btn btn-primary me-5 btn-sm hover-elevate-up">
                    <i class="ki-duotone ki-plus-circle fs-3">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    Nouvelle catégorie
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
            <div class="table-responsive">
                <table id="ajax-datatable-categorie" class="table align-middle table-row-dashed fs-6 gy-5 border rounded ">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>#</th>
                            <th>Libellé</th>
                            <th>code</th>
                            <th>Date ajout</th>
                            <th>Auteur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    <form id="form" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="categorie_id" id="categorie_id">
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal-categorie">
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
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Nom catégorie</label>
                            <input type="text" name="nom_categorie" id="nom_categorie_id"  class="form-control mb-2">
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Nom catégorie</label>
                            <input type="text" name="code_categorie" id="code_categorie_id"  class="form-control mb-2">
                        </div>
                        {{--  <div class="mb-5 fv-row">
                            <label class="required form-label">Code catégorie</label>
                            <select class="form-select" data-control="select2" id="code_categorie_id" data-placeholder="Choisir un code" name="code_categorie">
                                <option></option>
                                @foreach (config('constants.CODE_CATEGORIE_PRODUIT') as $value => $status)
                                    <option value="{{ $value }}">{{ Str::ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>  --}}

                        {{--  <div class="mb-5 fv-row">
                            <label class="required form-label">Famille</label>
                            <select class="form-select" name="sous_famille_id" id="sous_famille_id" data-control="select2" data-placeholder="Sélectionner une famille">
                                <option></option>
                                @foreach ($sous_familles as $sous_famille)
                                        <option value="{{ $sous_famille->id }}">{{ $sous_famille->name }}</option>
                                @endforeach
                            </select>
                        </div>  --}}
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
