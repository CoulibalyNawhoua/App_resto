<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form id="OrderDeliveryForm" action="{{ route('orders.delivery.store') }}" data-redirect="{{ route('orders.deposit.index') }}" method="post">
        @csrf
        <input type="hidden" name="product_count" id="product_count" class="product_count" value="0">
        <input type="hidden" name="order_id" value="{{$order->id}}">
        <input type="hidden" name="depot_deuctible_id" value="{{$order->destination_id }}">
        <div class="card shadow-sm mt-10">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Livraison</h2>
                </div>
            </div>
            <div class="card-body pt-10">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3 col-md-12">
                            <label for="" class="form-label">Dépôt destination</label>
                            <select disabled class="form-select rounded-0" data-control="select2"  data-placeholder="Aucune sélection" name="destination_id">
                                @foreach ($entrepots as $entrepot)
                                    <option value="{{ $entrepot->id }}" @if ($entrepot->id == $order->entite_id) selected @endif>{{ $entrepot->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-3 col-md-12">
                            <label class="form-label">Date commande</label>
                            <input class="form-control rounded-0" readonly name="order_date" disabled value="{{ $order->order_date }}" placeholder="Date commande" id="date_commande_id"/>
                        </div>
                        <div class="fv-row col-md-12">
                            <label class="form-label">Statut Livraison</label>
                            <select class="form-select rounded-0" data-hide-search="true" data-control="select2" required name="delivery_status">
                                @foreach (config('constants.ORDER_DELIVERY_STATUS') as $value => $status)
                                    <option value="{{ $value }}" @if ($order->delivery_status == $value) @endif>{{ Str::ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Date préparation livraison</label>
                                <input class="form-control rounded-0" name="delivery_preparation_date"  placeholder="Date préparation" id="delivery_add_date_id"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date livraison</label>
                                <input class="form-control rounded-0" name="delivery_date"  placeholder="Date prévue pour la livraison" id="delivery_date_id"/>
                            </div>
                        </div>

                        <div class="fv-row col-md-12">
                            <label class="form-label">Note</label>
                           <textarea name="note"  class="form-control rounded-0" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="table-responsive  mt-10">
                    <table  id="tabpanier-id" class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                            <tr class="fw-bold fs-6 text-gray-800 " >

                                <th class="w-20px"></th>
                                <th class="w-500px">produit</th>
                               {{-- <th class="w-500px">Stock</th>--}}
                                <th class="w-500px">Qté commandée</th>
                                  <th class="w-500px">Unité</th>
                                <th class="w-500px">Qté à livrer</th>
                               {{-- <th class="fw-bold flex-right">Supprimer</th>--}}
                            </tr>
                        </thead>
                        <tbody id="tabpanier-id">
                            @foreach ($orderProducts as $item)
                                <tr>
                                    <input type="hidden" name="products[]" id="product_{{ $item->produit_id }}" value="{{ $item->produit_id }}">
                                    <td><input type="checkbox" name="accepted[]" value="0" onclick="confirmDeliveryProduct(this)"></td>
                                    <td class="w-500px">{{ $item->nom_produit }}</td>
                                   {{-- <td class="w-500px"> @if ($item->quantite_stock ) {{ $item->quantite_stock }} @else 0 @endif  {{ $item->name }}</td>--}}
                                    <td class="w-500px">
                                        {{--<span class="order_qantity">{{ $item->quantity }}</span> @if($item->product_unit) {{ $item->product_unit->unite->name }} @endif--}}
                                        <input type="number" name="order_qantity[]" readonly value="{{ $item->quantity }}" class="form-control  h-30px p-1 rounded-0 order_qantity">
                                    </td>
                                    <td class="w-300px">
                                        <select name="product_unit[]" class="form-select h-30px p-1 rounded-0 product_unit"   required="" id="unit_id{{ $item->produit_id }}">
                                            <option disabled value="">Aucun</option>
                                            @foreach ($item->product_units as $i)
                                                <option data-price="{{ $i->price }}" @if($i->id != $item->product_unit_id) disabled @elseif($i->id == $item->product_unit_id) selected @endif value="{{ $i->id }}">{{ $i->unite->name }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="w-500px"><input type="number" name="quantity[]" readonly value="0" class="form-control  h-30px p-1 rounded-0 quantity_delivery"></td>
                                   {{-- <td class="fw-bold flex-right">
                                        <a href="javascript:;" onclick="deleteSub(this, 0);" class="btn btn-icon btn-danger rounded-circle panier_btn_remove pulse h-30px w-30px"><span class="svg-icon svg-icon-2"><i class="fa fa-bold fa-close"></i></span><span class="pulse-ring"></span></a>
                                    </td>--}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-10">
            <button type="submit" id="btn-submit-delivery-order" class="btn btn-primary">
                <span class="indicator-label">ENREGISTRER</span>
                <span class="indicator-progress">Veuillez patienter.....
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>


</x-default-layout>
