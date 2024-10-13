<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form id="ReceiptForm" action="{{ route('orders.receipt.store') }}" data-redirect="{{ route('orders.index') }}" method="post">
        @csrf
        <input type="hidden" name="product_count" id="product_count" class="product_count" value="0">
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <div class="row mb-5 mt-10">
            <div class="col-md-6">
                <div class="card shadow-sm mb-1">
                    <div class="card-header">
                        <h3 class="card-title">Gestion réception</h3>
                        <div class="card-toolbar">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="fv-row col-md-4">
                                    <label class="form-label">Référence commande</label>
                                    <input class="form-control rounded-0" disabled value="{{ $order->reference }}" placeholder="Référence n°"/>
                                </div>
                                <div class="fv-row col-md-4">
                                    <label class="form-label">Date</label>
                                    <input class="form-control rounded-0"  name="date_reception" placeholder="Date recéption" id="date_reception_id"/>
                                </div>
                                <div class="fv-row col-md-4">
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
            <div class="col-md-6">
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
                                <div class="text-end fw-norma">{{ Date::parse($order->add_date)->locale('fr')->format('l j F Y') }}</div>
                            </div>
                            <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                <div class="fw-semibold pe-5">Montant TTC:</div>
                                <div class="text-end fw-norma">{{ number_format($order->total_amount) }} FCFA</div>
                            </div>

                            <div class="d-flex flex-stack text-gray-800 fs-6 mb-3">
                                <div class="fw-semibold pe-5">Reférence commande:</div>
                                <div class="text-end fw-norma">{{ $order->reference }}</div>
                            </div>

                          {{--  <div class="d-flex flex-stack text-gray-800 fs-6 mb-3">
                                <div class="fw-semibold pe-5">Reférence:</div>
                                <div class="text-end fw-norma">{{ $order->reference }}</div>
                            </div>--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mt-10">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>RECEPTION COMMANDE</h2>
                </div>
            </div>
            <div class="card-body pt-10">
                <div class="mt-10 fv-row">
                    <select class="form-select rounded-0" data-control="select2" id="search-product-select2" disabled data-placeholder="Aucune sélection">
                        <option></option>

                    </select>
                </div>
                <div class="table-responsive  mt-10">
                    <table  id="tabpanier-id" class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                        <tr class="fw-bold fs-6 text-gray-800 " >
                            <th class="w-30px"></th>
                            <th class="w-500px">produit</th>
                            <th class="w-300px">Qte commandée</th>
                            <th class="w-300px">Unité</th>
                            <th class="w-300px">Prix unitaire</th>
                            <th class="w-300px">Quantité</th>
                            <th class="w-300px">Total</th>
                        </tr>
                        </thead>
                        <tbody id="tabpanier-id">
                        @foreach ($order_products as $item)
                            <tr>
                                <input type="hidden" name="products[]" id="product_{{ $item->produit_id }}" value="{{ $item->produit_id }}">
                                <td class="w-30px"><input type="checkbox" value="0" class="mark_received" name="mark_received[]" onchange="confirmRecevedProduct(this)"></td>
                                <td class="w-500px"><span id="productName_{{ $item->produit_id }}">{{ $item->produit->nom_produit }}</span></td>
                                <td class="w-200px"><input type="text" readonly  name="quantite_commande[]" class="form-control quantity h-30px p-1 rounded-0" value="{{ $item->quantity }}"></td>
                                <td class="w-300px">
                                    <select name="product_unit[]" class="form-select h-30px p-1 rounded-0 product_unit" readonly=""  onchange="change_unit_get_price(this);" required="" id="unit_id{{ $item->produit_id }}">
                                        <option value="" disabled>Aucun</option>
                                        @foreach ($item->product_units as $i)
                                            <option data-price="{{ $i->price }}"  @if($i->id != $item->product_unit_id) disabled @endif value="{{ $i->id }}">{{ $i->unite->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="w-300px"><input type="text"  readonly="" name="unite_price[]" value="{{ $item->unite_price }}" class="form-control  h-30px p-1 rounded-0 product_unit_price"></td>
                                <td class="w-300px"><input type="text" readonly  required="" name="quantite[]" min="1" class="form-control  h-30px p-1 rounded-0 quantity_received" value="0" onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></td>
                                <td class="w-300px sous-total"><input type="text"  readonly="" name="sousTotal[]" class="form-control  h-30px p-1 rounded-0 sousTotal" value="0"></td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6" style="text-align: right">Total</td>
                            <td class="w-300px">
                                <input type="text" id="total_amount" readonly name="total_amount" class="form-control rounded-0 h-30px p-1" value="0"/>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-10">
            <button type="submit" id="btn-submit-receipt" class="btn btn-primary">
                <span class="indicator-label">ENREGISTRER</span>
                <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
</x-default-layout>
