
<x-default-layout>
    <form id="form" method="POST" data-redirect="" action="{{ route('unites.update',$unite->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <h3 class="card-title">Modifier unité</h3>
                <div class="card-toolbar">
                    {{-- <a href="javascript:;" onclick="Add()" class="btn btn-primary btn-sm hover-elevate-up">Nouvelle famille</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="mb-10 fv-row">
                    <label class="required form-label">Libelle</label>
                    <input type="text" name="name"  value="{{ $unite->name }}"  class="form-control mb-2">
                </div>
                <div class="mb-10 fv-row">
                    <label class="form-label">Groupe unité conversion</label>
                    @foreach ($unitGroups as $unitGroup)
                    <div class="mb-10">
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" {{ $unitGroup->units->contains($unite->id) ? 'checked' : '' }} name="groups[]" value="{{ $unitGroup->id }}"/>
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
    </x-base-layout>
