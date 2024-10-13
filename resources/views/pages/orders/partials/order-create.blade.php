<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form id="OrderForm" action="{{ route('orders.store') }}" data-redirect="{{ route('orders.index') }}" method="post">
        @csrf
        <input type="hidden" name="product_count" id="product_count" class="product_count" value="0">
        <div class="card shadow-sm mt-10">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Nouvelle commande central achat</h2>
                </div>
            </div>
            <div class="card-body pt-10">
                <div class="mb-3 col-md-3">
                    <label for="" class="form-label">Destination</label>
                    <select class="form-select" data-control="select2" onchange="depotChange(this)" id="destination_id" data-placeholder="Sélectionner une destination" name="destination_id">
                        <option></option>
                        @foreach ($destinations as $destination)
                            <option  value="{{ $destination->id }}">{{ $destination->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fv-row mb-3 col-md-3">
                    <label class="form-label">Date commande</label>
                    <input class="form-control rounded-0" name="order_date" placeholder="Date commande" id="date_commande_id"/>
                </div>
                <div class="fv-row col-md-3">
                    <label class="form-label">Statut</label>
                    <select class="form-select rounded-0" data-hide-search="true" data-control="select2" required name="order_status">
                        @foreach (config('constants.STATUS_ORDER') as $value => $status)
                            <option value="{{ $value }}">{{ Str::ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-10 fv-row">
                    <select class="form-select rounded-0" data-control="select2" id="search-product-select2" data-placeholder="Aucune sélection">
                        <option></option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->nom_produit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive h-350px align-items-center flex-center bg-light-secondary mt-10">
                    <table  id="tabpanier-id" class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                        <tr class="fw-bold fs-6 text-gray-800 " >
                            <th class="w-500px">produit</th>
                            <th class="w-500px">Unité</th>
                            <th class="w-500px">Quantité</th>
                            <th class="fw-bold flex-right">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="tr-1">
                            <td></td>
                            <td class="align-items-center flex-center  text-align-center">Aucun produit selectionné!</td>
                            <td></td>
                        </tr>
                        </tbody>
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
