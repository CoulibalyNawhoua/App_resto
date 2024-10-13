<x-default-layout>
    <x-default-layout>
        <div id="message"></div>
        <form id="EditRecetteForm" method="POST" data-redirect="{{ route('index-recette') }}" action="{{ route('recette-update', $recette->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="item_count" id="item_count" value="{{ $recette->fichesTechniques->count() }}">
            <div class="card shadow-sm mt-10">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Nouvelle</h2>
                    </div>
                </div>

                <div class="card-body pt-10">
                    <div class="mb-5 fv-row">
                        <label class="form-label">Libellé </label>
                        <input type="text" name="libelle" required  value="{{ $recette->name }}" class="form-control mb-2">
                    </div>
                    <div class="mb-5 fv-row">
                        <label class="form-label">prix</label>
                        <input type="number" name="prix_unitaire" value="{{ $recette->prix_unitaire }}" min="0" class="form-control mb-2">
                    </div>

                    <label class="form-label fw-bolder">Ingrédient</label>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive mb-10">
                                <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items" id="table-ajouter-item">
                                    <thead>
                                    <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                        <th class="min-w-100px w-100px">Produit</th>
                                        <th class="min-w-100px w-100px">Unité</th>
                                        <th class="min-w-100px w-100px">Quantité</th>
                                        <th class="min-w-75px w-75px text-end">
                                            <button type="button" title="Ajouter une heure" class="btn btn-sm btn-icon btn-active-color-primary" id="button-add-item">
                                                <i class="las la-plus-circle fs-2x"></i>
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($recette->fichesTechniques as $item)
                                        <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                            <input type="hidden" name="fiche_item[]" value="{{ $item->id }}">
                                            <td>
                                                <select name="produits[]" class="form-select rounded-0" required="" >
                                                    <option value="">Aucun</option>
                                                    @foreach($produits as $produit)
                                                        <option value="{{ $produit->id }}" @if($produit->id == $item->produit_id) selected @endif>{{ $produit->nom_produit }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="ps-0">
                                                <select name="unites[]" class="form-select rounded-0" required="">
                                                    <option value="">Aucun</option>
                                                    @foreach($item->produit->unite->groupsUnits as $unite)
                                                        <option value="{{ $unite->id }}" @if($unite->id == $item->groupe_unite_id) selected @endif>{{ $unite->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control rounded-0" min="0" step='0.01' value="{{ $item->quantity }}" required="" name="quantity[]">
                                            </td>
                                            <td class="pt-6 text-end">
                                                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" onclick="deleteSub(this,{{ $item->id }})">
                                                    <i class="las la-trash-alt fs-2x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" id="btn-add-item" class="btn btn-primary">
                        <span class="indicator-label">Enregistrer</span>
                        <span class="indicator-progress">Veuillez patienter...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </form>
    </x-default-layout>

</x-default-layout>
