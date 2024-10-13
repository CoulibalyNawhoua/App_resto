<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form  id="ReceiptForm" method="POST" action="{{ route('purchase-receipt-store', $procurment->id) }}" data-redirect="{{ route('procurments.providers.index') }}" enctype="multipart/form-data">
        @csrf
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
                            <input type="hidden" name="product_count" id="product_count" class="product_count" value="0">
                            <input type="hidden" name="procurement_id" id="procurement_id" value="{{ $procurment->id }}">
                            <div class="row">
                                <div class="row">
                                    <div class="mb-5 fv-row col-md-6">
                                        <label class="required form-label">Dépôt stockage</label>
                                        <select class="form-select rounded-0" data-control="select2" data-hide-search="true" name="depot_stockage">
                                            @foreach ($depot_stockages as $depot_stockage)
                                                <option value="{{ $depot_stockage->id }}" @if($depot_stockage->id == $procurment->entite_id) selected @elseif($depot_stockage->id != $procurment->entite_id) disabled @endif>{{ $depot_stockage->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="fv-row col-md-3">
                                        <label class="form-label">Date</label>
                                        <input class="form-control rounded-0"  name="date_reception" placeholder="Date recéption" id="date_reception_id"/>
                                    </div>
                                    <div class="fv-row col-md-3">
                                        <label class="form-label">Référence n°</label>
                                        <input class="form-control rounded-0" name="invoice_reference" placeholder="Référence n°"/>
                                    </div>
                                </div>

                                <div class="row mb-10">
                                        <div class="fv-row col-md-12">
                                        <label class="form-label">Commentaire</label>
                                        <textarea name="commentaire"  class="form-control rounded-0" rows="2"></textarea>
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
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-info fw-bold">Validation en attente</span>
                                        @endif

                                        @if($procurment->procurment_status == 1)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-warning fw-bold">Réception en cours</span>
                                        @endif

                                        @if($procurment->procurment_status == 2)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-success fw-bold">Clôturée</span>
                                        @endif

                                        @if($procurment->procurment_status == 3)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-danger fw-bold">Annulée</span>
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
                <div class="table-responsive">
                    <table   class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                            <tr class="fw-bold fs-6 text-gray-800" >
                                <th class="w-30px"></th>
                                <th class="w-300px">Produit</th>
                                <th class="w-200px">Unité</th>
                                <th class="w-200px">Qté commandée</th>
                                <th class="w-200px">Qté déjà réceptionnée</th>
                                <th class="w-200px">Qté réceptionnée</th>
                                <th class="w-200px">Prix achat</th>
                                <th class="w-200px">SousTotal</th>
                            </tr>
                        </thead>
                        <tbody id="tabpanier-id" >
                            @foreach ($procurement_products as $item)
                                <tr>
                                    <input type="hidden" name="products[]" id="product_{{ $item->id }}" value="{{ $item->produit_id }}|{{ $item->id }}">
                                    <td class="w-30px"><input type="checkbox" value="0" class="mark_received" name="mark_received[]" onchange="confirmRecevedProduct(this)"></td>
                                    <td class="w-300px">{{ $item->produit->nom_produit }}</td>
                                    <td class="w-300px">
                                        <select name="product_unit[]" class="form-select h-35px p-1 rounded-0 product_unit" onchange="change_unit_get_price(this);" required="" id="unit_id{{ $item->produit_id }}">
                                            @foreach ($item->product_units as $i)
                                                <option data-price="{{ $i->price }}" @if($i->id != $item->product_unit_id) disabled @else selected @endif value="{{ $i->id }}">{{ $i->unite->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="w-200px"><input type="number" readonly  name="quantity[]" value="{{ $item->quantity }}"  class="form-control  h-35px p-1 rounded-0 quantity" ></td>
                                    <td class="w-200px"><input type="number" readonly  name="quantity_already_received[]" value="{{ $item->quantity_received }}"  class="form-control  h-35px p-1 rounded-0 quantity_already_received" ></td>
                                    <td class="w-200px"><input type="number" readonly  name="quantity_received[]" value="0" step="0.01" min="0.01" class="form-control  h-35px p-1 rounded-0 quantity_received"  onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></td>
                                    <td class="w-200px"><input type="number" readonly  name="purchase_price[]" min="0" value="{{ $item->purchase_price }}" class="form-control  h-35px p-1 rounded-0 purchase_price" onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></td>
                                    <td class="w-200px sous-total"><input type="text"  readonly="" name="subtotal[]" class="form-control  h-35px p-1 rounded-0 subtotal" value="0"></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="w-30px"></td>
                            <td class="w-300px"></td>
                            <td class="w-300px"></td>
                            <td class="w-200px"></td>
                            <td class="w-200px"></td>
                            <td class="w-200px"></td>
                            <td class="w-200px">Total</td>
                            <td class="w-200px">
                                <input type="text" id="totalReceiptPrice" readonly name="total_receipt_price" class="form-control rounded-0 h-30px p-1" value="0"/>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
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
