<x-default-layout>
    <form id="OrderForm" action="{{ route('orders.update', $order->reference) }}" data-redirect="{{ route('orders.index') }}" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="product_count" id="product_count" class="product_count" value="{{ $order->orderProducts->count() }}">
        <div class="card shadow-sm mt-10">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>MODIFIER COMMANDE</h2>
                </div>
            </div>
            <div class="card-body pt-10">
                <div class="row mb-10">
                    <div class="mb-3 col-md-3">
                        <label for="" class="form-label">Destination</label>
                        <select class="form-select rounded-0" data-control="select2"  data-placeholder="Aucune sélection" name="destination_id">
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->id }}" @if ($destination->id == $order->destination_id) selected @endif>{{ $destination->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fv-row mb-3 col-md-2">
                        <label class="form-label">Date commande</label>
                        <input class="form-control rounded-0" readonly name="order_date" value="{{ $order->order_date }}" placeholder="Date commande" id="date_commande_id"/>
                    </div>
                    <div class="fv-row col-md-2">
                        <label class="form-label">Statut commande</label>
                        <select class="form-select rounded-0" data-hide-search="true" data-control="select2" required name="order_status">
                            @foreach (config('constants.STATUS_ORDER') as $value => $status)
                                <option value="{{ $value }}" @if ($value == $order->order_status) selected @endif>{{ Str::ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-20 fv-row">
                    <select class="form-select rounded-0" data-control="select2" id="search-product-select2" data-placeholder="Aucune sélection">
                        <option></option>
                        @foreach ($dataProduct as $produit)
                            <option value="{{ $produit->id }}">{{ $produit->nom_produit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive  mt-10">
                    <table  id="tabpanier-id" class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                        <tr class="fw-bold fs-6 text-gray-800 " >
                            <th class="w-500px">produit</th>
                            <th class="w-300px">Unité</th>
                            <th class="w-300px">Prix unitaire</th>
                            <th class="w-300px">Quantité</th>
                            <th class="w-300px">Total</th>
                            <th class="fw-bold flex-right">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody id="tabpanier-id">
                            @foreach ($order_products as $item)
                                <tr>
                                    <input type="hidden" name="products[]" id="product_{{ $item->produit_id }}" value="{{ $item->produit_id }}">
                                    <td class="w-500px"><span id="productName_{{ $item->produit_id }}">{{ $item->produit->nom_produit }}</span></td>
                                    <td class="w-300px">
                                        <select name="product_unit[]" class="form-select h-30px p-1 rounded-0 product_unit" onchange="change_unit_get_price(this);" required="" id="unit_id{{ $item->produit_id }}">
                                            <option value="">Aucun</option>
                                            @foreach ($item->product_units as $i)
                                                <option data-price="{{ $i->price }}" @if($i->id == $item->product_unit_id) selected @endif value="{{ $i->id }}">{{ $i->unite->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="w-300px"><input type="text"  readonly="" name="unite_price[]" value="{{ $item->unite_price }}" class="form-control  h-30px p-1 rounded-0 cout_product"></td>
                                    <td class="w-300px"><input type="text"  required="" name="quantity[]" min="1" class="form-control  h-30px p-1 rounded-0 quantite_product" value="{{ $item->quantity }}" onchange="calculePrixSousTotal(this);" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></td>
                                    <td class="w-300px sous-total"><input type="text"  readonly="" name="sousTotal[]" class="form-control rounded-0 h-30px p-1 sousTotal" value="{{ $item->quantity * $item->unite_price}}"></td>
                                    <td class="fw-bold flex-right">
                                        <a href="javascript:;" onclick="deleteSub(this, {{ $item->id }}, {{ $item->produit_id }});" class="btn btn-icon btn-danger panier_btn_remove pulse h-30px w-30px"><span class="svg-icon svg-icon-2"><i class="fa fa-bold fa-close"></i></span><span class="pulse-ring"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="w-500px"></td>
                            <td class="w-300px"></td>
                            <td class="w-300px"></td>
                            <td class="w-300px">Total</td>
                            <td class="w-300px">
                                <input type="text" id="total_a_payer_id" readonly name="total_amount" class="form-control rounded-0 h-30px p-1" value="{{ $order->total_amount }}"/>
                            </td>
                            <td class="w-100px"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer ">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" id="btn-submit-order" class="btn btn-primary">
                        <span class="indicator-label">ENREGISTRER</span>
                        <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-default-layout>
