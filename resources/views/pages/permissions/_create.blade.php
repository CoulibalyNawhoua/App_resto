
<x-default-layout>
    <form id="form" method="POST"  data-redirect="{{ route('permissions.index') }}" action="{{ route('permissions.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                       Nouvelle permission
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-10 fv-row">
                    <label class="required form-label">Libelle</label>
                    <input type="text" autocomplete="off" name="name" class="form-control mb-2" placeholder="Libelle" >
                </div>
            </div>
            <div class="card-footer">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" id="btn-add" class="btn btn-primary">
                        <span class="indicator-label">ENREGISTRER</span>
                        <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-default-layout>
