
<x-default-layout>
    <form id="form" method="POST" data-redirect="{{ route('settings.index') }}" action="{{ route('settings.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <h3 class="card-title">Modifier les parametres</h3>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <div class="fv-row mb-5 w-100 flex-md-root">
                    <label class="form-label">Stockage </label>
                    <select class="form-select" data-control="select2" data-placeholder="Emplacement par défaut" name="default_stockage">
                        <option value="">Aucun(e)</option>
                        @foreach ($depots as $depot)
                            <option value="{{ $depot->id , config('settings.default_stockage')}}">{{ $depot->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer ">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" id="btn-add" class="btn btn-primary">
                        <span class="indicator-label">ENREGISTRER</span>
                        <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</x-default-layout>
