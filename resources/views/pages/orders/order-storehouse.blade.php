<x-default-layout>
    <div class="card shadow-sm mt-10">
        <div class="card-header">
            <h3 class="card-title">Commandes des dépôts</h3>
            <div class="card-toolbar">

            </div>
        </div>
        <div class="card-body">
            <table id="ajax-datatable-order-storehouse" class="table table-rounded border gy-7 gs-7">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>#</th>
                        <th>Réference</th>
                        <th>Dépôt de provenance</th>
                        <th>Statut Commande</th>
                        {{--<th>Statut réception</th>--}}
                        <th>date</th>
                        <th>Auteur</th>
                       {{-- <th>Livraison en cours</th>--}}
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

 {{--   <form id="form" method="POST" action="{{ route('cancel-order') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" tabindex="-1" id="modal-refund-order" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <input type="hidden" name="order_id" id="order_id">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Modal title</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <div class="modal-body">
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Note</label>
                            <textarea name="note" class="form-control" id="confirm_note" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-refund-form" class="btn btn-primary">
                            <span class="indicator-label">ENREGISTRER</span>
                            <span class="indicator-progress">Veuillez patienter.....
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>--}}
</x-default-layout>
