<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form id="AddProductForm" method="POST" data-redirect="{{ route('produits.index') }}" action="{{ route('produits.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-sm mt-10">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Nouveau produit</h2>
                </div>
            </div>

            <input type="hidden" name="produit_a_une_unite" id="produit_a_une_unite" value="0">
            <div class="card-body pt-10">
                <div class="mb-5 fv-row">
                    <label class="form-label">Référence</label>
                    <input type="text" name="reference_produit" id="reference_produit_id"  class="form-control mb-2">
                </div>
                <div class="mb-5 fv-row">
                    <label class="required form-label">Désignation</label>
                    <input type="text" name="nom_produit" id="nom_produit_id" required  class="form-control mb-2">
                </div>
                {{--  <div class="mb-5 fv-row">
                    <label class="form-label">Sous famille</label>
                    <select class="form-select" name="sous_famille_id" id="sous_famille_id" data-control="select2" data-placeholder="Aucun(e)">
                        <option></option>
                        @foreach ($sous_familles as $sous_famille)
                                <option value="{{ $sous_famille->id }}">{{ $sous_famille->name }}</option>
                        @endforeach
                    </select>
                </div>  --}}
                <div class="mb-5 fv-row">
                    <label class="required form-label">Catégorie</label>
                    <select class="form-select" name="categorie_id" required id="categorie_id" data-control="select2" data-placeholder="Aucun(e)">
                        <option></option>
                        @foreach ($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom_categorie }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-5 fv-row">
                    <label class="required form-label">Unité de gestion</label>
                    <select class="form-select" name="unite_id"  id="unite_id" required data-control="select2" data-placeholder="Aucun(e)">
                        <option></option>
                        @foreach ($unites as $unite)
                                <option value="{{ $unite->id }}">{{ $unite->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{--  <div class="mb-5 fv-row">
                    <label class="form-label">Pcb produit</label>
                    <input type="number" name="pcb_product" required id="pcb_product_id"  class="form-control mb-2">
                </div>  --}}

                <label class="form-label fw-bolder">Condition achat</label>

                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive mb-10">
                            <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items" id="table-ajouter-tarif">
                                <thead>
                                    <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                        <th class="min-w-100px w-100px">Unité</th>
                                        <th class="min-w-100px w-100px">Pcb</th>
                                        <th class="min-w-100px w-100px">Prix/unité</th>
                                        <th class="min-w-75px w-75px text-end">
                                            <button type="button" title="Ajouter une unité" class="btn btn-sm btn-icon btn-active-color-primary" id="btn-add-item">
                                                <i class="las la-plus-circle fs-2x"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" id="btn-add-product" class="btn btn-primary">
                    <span class="indicator-label">Enregistrer</span>
                    <span class="indicator-progress">Veuillez patienter...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </form>
</x-default-layout>
