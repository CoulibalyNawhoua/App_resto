<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form  id="form" method="POST" action="{{ route('purchase-update', $procurment->id) }}" data-redirect="{{ route('procurments.providers.index') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Modifier achat fournisseur</h3>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="product_count" id="product_count" class="product_count" value="{{ $procurment->procurementProduits->count() }}">

                <div class="row mb-3">
                    <div class="fv-row col-md-3">
                        <label class="required form-label">Fournisseur commande</label>
                        <select class="form-select rounded-0" data-control="select2" required name="fournisseur">
                            {{--  <option></option>  --}}
                            @foreach ($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom_complet }}</option>
                                @if ($fournisseur->id  == $procurment->fournisseur_id) selected @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5 fv-row col-md-3">
                        <label class="required form-label">Dépôt stockage</label>
                        <select class="form-select rounded-0" data-control="select2" required name="depot_stockage">
                            @foreach ($depot_stockages as $depot_stockage)
                                <option value="{{ $depot_stockage->id }}"  @if($depot_stockage->id == $procurment->entites_id) selected @endif>{{ $depot_stockage->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="row">
                    <div class="fv-row col-md-3">
                        <label class="form-label">Date commande</label>
                        <input class="form-control rounded-0" value="{{ $procurment->date_commande }}" name="date_commande" placeholder="Date commande" id="date_commande_id"/>
                    </div>

                    <div class="fv-row col-md-3">
                        <label class="form-label">Date réception</label>
                        <input class="form-control rounded-0" value="{{ $procurment->date_prevue_reception }}" name="date_prevue_reception" placeholder="Date réception" id="date_reception_id"/>
                    </div>
                </div>
                <div class="row mb-10">
                     <div class="fv-row col-md-6">
                        <label class="form-label">Commentaire</label>
                       <textarea name="commentaire"  class="form-control rounded-0" rows="2">{{ $procurment->commentaire }}</textarea>
                    </div>
                </div>


                {{-- <div class="separator separator-dotted separator-content border-dark my-15"><span class="h6">PRODUITS ACHATS</span></div> --}}
                <div class="mb-10 fv-row">
                    {{--  <label class="form-label">Aucune séléction</label>  --}}
                    <select class="form-select rounded-0" data-control="select2" data-placeholder="Aucune séléction" id="search-product-select2">
                        <option></option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->nom_produit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive mt-10">
                    <table   class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                            <tr class="fw-bold fs-6 text-gray-800 " >
                                <th class="w-500px">produit</th>
                                <th class="w-300px">Unité</th>
                                <th class="w-300px">Prix unitaire</th>
                                <th class="w-300px">Quantité</th>
                                <th class="w-300px">Prix total</th>
                                <th class="fw-bold flex-right">Supprimer</th>
                            </tr>
                        </thead>
                        <tbody id="tabpanier-id" >

                            @foreach ($procurement_products as $item)
                                <tr>
                                    <input type="hidden" name="products[]" id="product_{{ $item->produit_id }}" value="{{ $item->produit_id }}">
                                    <td class="w-500px"><span id="productName_{{ $item->produit_id }}">{{ $item->produit->nom_produit }}</span></td>
                                    <td class="w-300px">
                                        <select name="product_unit[]" class="form-select h-30px p-1 rounded-0 product_unit" onchange="change_unit_get_price(this);" required="" id="unit_id{{ $item->produit_id }}">
                                            <option value="">Aucun</option>
                                            @foreach ($item->product_units as $i)
                                                <option data-price="{{ $i->price }}" @if($i->id == $item->product_unit_id) selected @endif value="{{ $i->id }}">{{ $i->unite->name }}</option>
                                            @endforeach
                                           {{-- @foreach ($item->product_units as $i)
                                                <option data-price="{{ $i->price }}" @if($i->id == $item->product_unit_id) selected @endif value="{{ $i->id }}">{{ $i->unite->name }} (Pcb = {{ $i->pcb }})</option>
                                            @endforeach--}}
                                        </select>
                                    </td>
                                    <td class="w-300px"><input type="text"  readonly="" name="cout_product[]" value="{{ $item->purchase_price }}" class="form-control  h-30px p-1 rounded-0 cout_product"></td>
                                    <td class="w-300px"><input type="text"  required="" name="quantite[]" min="1" class="form-control  h-30px p-1 rounded-0 quantite_product" value="{{ $item->quantity }}" onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></td>
                                    <td class="w-300px sous-total"><input type="text"  readonly="" name="sousTotal[]" class="form-control  h-30px p-1 rounded-0 sousTotal" value="{{ $item->total_purchase_price }}"></td>
                                    <td class="fw-bold flex-right">
                                        <a href="javascript:;" onclick="deleteSub(this, {{ $item->id }}, {{ $item->produit_id }});"  class="btn btn-icon btn-danger rounded-circle panier_btn_remove pulse h-30px w-30px"><span class="svg-icon svg-icon-2"><i class="fa fa-bold fa-close"></i></span><span class="pulse-ring"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            {{--  <tr id="tr-1">
                                <td></td>
                                <td class="align-items-center flex-center  text-align-center">Aucun produit selectionné!</td>
                                <td></td>
                            </tr>  --}}
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="w-500px"></td>
                            <td class="w-300px"></td>
                            <td class="w-300px"></td>
                            <td class="w-300px">Total</td>
                            <td class="w-300px">
                                <input type="text" id="total_a_payer_id" readonly name="total_a_payer" class="form-control  h-30px p-1 rounded-0" value="{{ $procurment->cost }}"/>
                            </td>
                            <td class="w-100px"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-10">
            <button type="button" id="closed-procurement-process" class="btn btn-primary">
                <span class="indicator-label">ENREGISTRER</span>
                <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
</x-default-layout>
