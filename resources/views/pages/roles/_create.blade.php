
<x-default-layout>
<form id="form" method="POST" data-redirect="{{ route('roles.index') }}" action="{{ route('roles.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card shadow-sm mt-10">
        <div class="card-header">
            <h3 class="card-title">Nouveau role</h3>
            <div class="card-toolbar">
                {{-- <a href="javascript:;" onclick="Add()" class="btn btn-primary btn-sm hover-elevate-up">Nouvelle famille</a> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="mb-10 fv-row">
                <label class="required form-label">Libelle</label>
                <input type="text" name="name" id="name"  class="form-control mb-2">
            </div>
            <div class="mb-10 fv-row">
                <label class="form-label">Permissions</label>
                @foreach ($permissions as $permission)
                <div class="mb-10">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"/>
                        <span class="form-check-label">
                            {{ $permission->name }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer ">
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
