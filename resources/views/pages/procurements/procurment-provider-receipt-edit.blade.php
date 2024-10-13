<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form  id="ReceiptForm" method="POST" action="{{ route('purchase-receipt-update', $reception->id) }}" data-redirect="{{ route('procurments.providers.index') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="row mb-5">
                <div class="col-md-8">
                    <div class="card shadow-sm mb-1">
                        <div class="card-header">
                            <h3 class="card-title">Gestion réception</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="product_count" id="product_count" class="product_count" value="{{$reception->produitReceptions->count()}}">
                            <div class="row">
                                <div class="row">
                                    <div class="mb-5 fv-row col-md-4">
                                        <label class="required form-label">Dépôt stockage</label>
                                        <select class="form-select rounded-0" data-control="select2" required name="depot_stockage_id" data-placeholder="Aucune sélection">
                                            @foreach ($depot_stockages as $depot_stockage)
                                                <option value="{{ $depot_stockage->id }}" @if ($depot_stockage->id == $reception->entite_id) selected @endif>{{ $depot_stockage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="fv-row col-md-4">
                                        <label class="form-label">Date</label>
                                        <input class="form-control rounded-0" value="{{ $reception->reception_date }}"  name="date_reception" placeholder="Date recéption" id="date_reception_id"/>
                                    </div>
                                    <div class="fv-row col-md-4">
                                        <label class="form-label">Référence n°</label>
                                        <input class="form-control rounded-0" value="{{ $reception->invoice_reference }}" required name="invoice_reference" placeholder="Référence n°"/>
                                    </div>
                                </div>

                                <div class="row mb-10">
                                        <div class="fv-row col-md-12">
                                        <label class="form-label">Commentaire</label>
                                        <textarea name="commentaire"  class="form-control rounded-0" rows="2">{{ $reception->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Resumé de la commande</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column mw-md-300px w-100">

                                <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                    <div class="fw-semibold pe-5">Date commande:</div>
                                    <div class="text-end fw-norma">{{ Date::parse($procurment->date_commande)->locale('fr')->format('l j F Y') }}</div>
                                </div>
                                <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                    <div class="fw-semibold pe-5">Montant TTC:</div>
                                    <div class="text-end fw-norma">{{ number_format($procurment->cost) }} FCFA</div>
                                </div>
                                <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                    <div class="fw-semibold pe-5">Fournisseur:</div>
                                    <div class="text-end fw-norma">{{ $procurment->fournisseur->nom }} {{ $procurment->fournisseur->prenom }}</div>
                                </div>
                                <div class="d-flex flex-stack text-gray-800 fs-6 mb-3">
                                    <div class="fw-semibold pe-5">Reférence:</div>
                                    <div class="text-end fw-norma">{{ $procurment->reference }}</div>
                                </div>
                                <div class="d-flex flex-stack text-gray-800 fs-6">
                                    <div class="fw-semibold pe-5">Statut réception:</div>
                                    <div class="text-end fw-norma">
                                        @if($procurment->procurment_status == 0)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-light-info fw-bold">En  cours</span>
                                        @endif

                                        @if($procurment->procurment_status == 1)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-light-primary fw-bold">En attente de livraison</span>
                                        @endif

                                        @if($procurment->procurment_status == 2)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-light-success fw-bold">Livré</span>
                                        @endif

                                        @if($procurment->procurment_status == 3)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-light-danger fw-bold">Annuler</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <div class="card shadow-sm">
              <div class="card-body pb-10">
                <div class="table-responsive align-items-center flex-center bg-light-secondary">
                    <table   class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                            <tr class="fw-bold fs-6 text-gray-800" >
                                <th class="w-30px"></th>
                                <th class="w-300px">Produit</th>
                                <th class="w-200px">Qté commandée</th>
                                <th class="w-200px">Qté déjà reçue</th>
                                <th class="w-200px">Modifier quantité</th>
                                <th class="w-200px">Prix achat</th>
                                <th class="w-200px">SousTotal</th>
                            </tr>
                        </thead>
                        <tbody id="tabpanier-id" >
                            @foreach ($procurment->procurementProduits as $item)
                                <tr>
                                    <input type="hidden" name="products[]" id="product_{{ $item->id }}" value="{{ $item->produit_id }}|{{ $item->id }}">
                                    <td class="w-30px"><input type="checkbox" value="{{ $item->product_receipt_status }}" @if ($item->product_receipt_status == 1) checked @endif class="mark_received" name="mark_received[]" onchange="confirmRecevedProduct(this)"></td>
                                    <td class="w-300px">{{ $item->produit->nom_produit }}</td>
                                    <td class="w-200px"><span class="quantity">{{ $item->quantity }}</span> {{ $item->produit->unite->name }}</td>
                                    <td class="w-200px">{{ $item->quantity_received }} {{ $item->produit->unite->name }}</td>
                                    <td class="w-200px"><input type="number" required data-quantity-received="{{ $item->quantity_received }}" value="{{ $item->quantity_received }}" @if ($item->product_receipt_status != 1) readonly @endif  value="0" name="quantity_received[]" min="0" class="form-control  h-30px p-1 rounded-0 quantity_received"  onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></td>
                                    <td class="w-200px"><input type="number"  name="purchase_price[]" min="1" value="{{ $item->unit_price }}" class="form-control  h-30px p-1 rounded-0 purchase_price" onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></td>
                                    <td class="w-200px sous-total"><input type="text"  readonly="" name="subtotal[]" class="form-control  h-30px p-1 rounded-0 subtotal" @if ($item->product_receipt_status == 1) value="{{ $item->total_purchase_price }}" @else value="0" @endif></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <table  class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                    <tbody>
                        <tr>
                            <td class="w-300px"></td>
                            <td class="w-200px"></td>
                            <td class="w-200px"></td>
                            <td class="w-200px"></td>
                            <td class="w-200px">Total</td>
                            <td class="w-200px">
                                <input type="text" id="totalReceiptPrice" readonly name="total_receipt_price" class="form-control  h-30px p-1 rounded-0" value="{{ $reception->total_receipt_price }}"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
           </div>
           <div class="d-flex justify-content-end mt-5">
              <button type="submit" id="btn-save-receipt" class="btn btn-primary">
                  <span class="indicator-label">ENREGISTRER</span>
                  <span class="indicator-progress">Veuillez patienter...
                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
              </button>
           </div>
        </div>
     </form>
</x-default-layout>
