<x-default-layout>
    <form id="add_form" method="POST" data-redirect="{{ route('users.index') }}" action="{{ route('store.user.permission',$user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <h3 class="card-title"> AUTORISATION DE L'UTILISATEUR : {{ $user->name }}</h3>
                <div class="card-toolbar">
                    {{--  <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm hover-elevate-up">Nouveau utilisateur</a>  --}}
                </div>
            </div>
            <div class="card-body">
                <div class="mb-10 fv-row">
                    <input type="hidden" name="{{ $user->id }}">
                    <label class="form-label">Permissions</label>
                    @foreach ($permissions as $permission)
                    <div class="mb-10">
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" {{ $user->permissions->contains($permission->id) ? 'checked' : '' }} name="permissions[]" value="{{ $permission->id }}"/>
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
                    <button type="submit" id="kt_add_permission_user_submit" class="btn btn-primary">
                        <span class="indicator-label">ENREGISTRER</span>
                        <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    </x-default-layout>
