<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form id="addForm" action="{{ route('ajustement-store') }}" data-redirect="{{ route('products.ajustement.index') }}" method="post">
        @csrf
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <h3 class="card-title">Saisie manuelle des sorties de stock</h3>
                <div class="card-toolbar">

                </div>
            </div>
            <div class="card-body">
                <div class="col-lg-12 mb-10">
                    <input class="form-control rounded-0 typeahead" autocomplete="off" id="product_search" type="text"  placeholder=""/>
                </div>
                <div class="table-responsive  mt-10">
                    <table  id="tabpanier-id" class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                        <tr class="fw-bold fs-6 text-gray-800 " >
                            <th class="w-400px">produit</th>
                            <th class="w-300px">Unité</th>
                            <th class="w-400px">Opération</th>
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
                <input type="hidden" name="operation_type" value="adjustment">
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