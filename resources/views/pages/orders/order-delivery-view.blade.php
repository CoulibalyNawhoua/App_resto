<x-default-layout>
    <form id="form" action="{{ route('delivery-cancel', $delivery->id) }}" data-redirect="" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <div class="card-title">
                    <h2>Détails livraison</h2>
                </div>
            </div>
            <div class="card-body pt-10">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3 col-md-12">
                            <label for="" class="form-label">Dépôt stockage</label>
                            <input class="form-control rounded-0" disabled  value="{{ $order->entite->name }}"/>
                        </div>
                        <div class="fv-row mb-3 col-md-12">
                            <label class="form-label">Date commande</label>
                            <input class="form-control rounded-0" disabled  value="{{ $order->order_date }}"  id="date_commande_id"/>
                        </div>
                        <div class="fv-row mb-3 col-md-12">
                            <label class="form-label">Référence commande</label>
                            <input class="form-control rounded-0" disabled name="order_date" value="{{ $order->reference }}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Date prévue pour la livraison</label>
                                <input class="form-control rounded-0" disabled value="{{ $delivery->delivery_date }}" id="delivery_date_id"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Référence livraison</label>
                                <input class="form-control rounded-0" disabled value="{{ $delivery->reference }}"/>
                            </div>
                        </div>
                        <div class="fv-row  col-md-12">
                            <label class="form-label required">Motif annulation</label>
                           <textarea name="commentaire" class="form-control rounded-0" rows="5">{{ $delivery->commentaire }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="table-responsive  mt-10">
                    <table  id="tabpanier-id" class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                            <tr class="fw-bold fs-6 text-gray-800 " >
                                <th class="w-20px">#</th>
                                <th class="w-500px">produit</th>
                                <th class="w-500px">Unité</th>
                                <th class="w-500px">Qté livraison</th>
                            </tr>
                        </thead>
                        <tbody id="tabpanier-id">
                            @foreach ($deliveryProducts as $item)
                                <tr>
                                    <input type="hidden" name="products[]" id="product_{{ $item->produit_id }}" value="{{ $item->produit_id }}">
                                    <td class="w-20px">{{ $loop->iteration }}</td>
                                    <td class="w-500px">{{ $item->produit->nom_produit }}</td>
                                    <td class="w-300px">
                                        <select name="product_unit[]" class="form-select h-30px p-1 rounded-0 product_unit"   required="" id="unit_id{{ $item->produit_id }}">
                                            <option disabled value="">Aucun</option>
                                            @foreach ($item->product_units as $i)
                                                <option  @if($i->id != $item->product_unit_id) disabled @elseif($i->id == $item->product_unit_id) selected @endif value="{{ $i->id }}">{{ $i->unite->name }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="w-500px"><input type="number" name="quantity[]" readonly value="{{ $item->quantity_delivered }}" class="form-control  h-30px p-1 rounded-0 quantity_delivery"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-10">
            <button type="submit" id="btn-submit-delivery-cancel"  class="btn btn-danger">
                <span class="indicator-label">RETOUNER DANS LE STOCK </span>
                <span class="indicator-progress">Veuillez patienter.....
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>

</x-default-layout>
