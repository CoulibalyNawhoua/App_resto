<x-default-layout>
    <form id="form" method="POST" action="{{ route('entites.update', $entite->id) }}" data-redirect="{{ route('entites.index') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card card-bordered mt-10">
            <div class="card-header">
                <h3 class="card-title">Modifier dépôt stockage</h3>
                <div class="card-toolbar">
                    {{--  <a href="javascript:;" onclick="addFunction()" class="btn btn-primary btn-sm hover-elevate-up">Nouveau dépôt</a>  --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="mb-5 fv-row">
                        <label class="required form-label">Intitulé</label>
                        <input type="text" name="nom_entite" id="nom_entite_id" value="{{ $entite->name }}"  class="form-control mb-2">
                    </div>

                    <div class="mb-5 fv-row">
                        <label class="form-label">Code dépôt</label>
                        <input type="text" name="code_depot" value="{{ $entite->code_depot }}" id="code_depot_id"  class="form-control mb-2">
                    </div>

                    <div class="mb-5 fv-row">
                        <label class="required form-label">Département</label>
                        <select class="form-select" name="departement_id" id="departement_id" data-control="select2" data-placeholder="Aucun(e)">
                            <option></option>
                            @foreach ($departements as $departement)
                                    <option value="{{ $departement->id }}" @if ($departement->id == $entite->departement_id) selected @endif>{{ $departement->nom_departement }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5 fv-row">
                        <label class="form-label">Adresse dépôt</label>
                        <input type="text" name="adresse_depot" value="{{ $entite->adresse_depot }}" id="adresse_depot_id"  class="form-control mb-2">
                    </div>

                    <div class="mb-5 fv-row">
                        <label class="form-label">Ville dépôt</label>
                        <input type="text" name="ville_depot" value="{{ $entite->ville_depot }}" id="ville_depot_id"  class="form-control mb-2">
                    </div>

                    <div class="mb-5 fv-row">
                        <label class="form-label">Téléphone dépôt</label>
                        <input type="text" name="telephone_depot" value="{{ $entite->telephone_depot }}" id="telephone_depot_id"  class="form-control mb-2">
                    </div>

                    <div class="mb-5 fv-row">
                        <input class="form-check-input" type="checkbox"  @hasrole('super-admin')  @else onclick="return false;"  @endhasrole name="use_depot_principal" @if ($entite->use_depot_principal == 1) checked onclick="return false;" @endif id="use_depot_principal_id">
                        <label class="form-check-label" for="">
                            Définir comme dépôt principal
                        </label>
                    </div>

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
