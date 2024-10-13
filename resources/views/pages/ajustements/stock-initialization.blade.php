<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form id="form" action="{{ route('stock-initialization-store') }}" data-redirect="{{ route('products.ajustement.index') }}" method="post">
        @csrf
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <h3 class="card-title">Initialisation stock</h3>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <div class="col-lg-12 mb-10">
                    <div class="mb-5 fv-row">
                        <select class="form-select rounded-0" data-control="select2" data-placeholder="Aucune séléction" id="select-product">
                            <option></option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->nom_produit }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive  mt-10">
                    <table  id="tabpanier-id" class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                        <tr class="fw-bold fs-6 text-gray-800 " >
                            <th class="w-400px">produit</th>
                            <th class="w-300px">Unité</th>
                            <th class="w-300px">Quantité</th>
                            <th class="fw-bold flex-right w-30px">Actions</th>
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
                <input type="hidden" name="product_count" id="product_count" class="product_count" value="0">
            </div>
        </div>
        <div class="d-flex justify-content-end mt-10">
            <button type="button" id="btn-submit-form" class="btn btn-primary">
                <span class="indicator-label">ENREGISTRER</span>
                <span class="indicator-progress">Veuillez patienter.....
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
</x-default-layout>
