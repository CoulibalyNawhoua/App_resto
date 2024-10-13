
<x-default-layout>
    <form id="form" method="POST" data-redirect="" action="{{ route('unites.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <h3 class="card-title">Nouvelle unité</h3>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <div class="mb-10 fv-row">
                    <label class="required form-label">Libellé</label>
                    <input type="text" name="name" id="name" class="form-control mb-2">
                </div>
                <div class="mb-10 fv-row">
                    <label class="form-label">Groupe unité conversion</label>
                    @foreach ($unitGroups as $unitGroup)
                    <div class="mb-10">
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="groups[]" value="{{ $unitGroup->id }}"/>
                            <span class="form-check-label">
                                {{ $unitGroup->name }}
                            </span>
                        </div>
                    </div>
                    @endforeach
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
