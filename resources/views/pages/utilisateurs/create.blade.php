
<x-default-layout>
    <form id="addUserForm" method="POST" data-redirect="{{ route('users.index') }}" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <h3 class="card-title">Ajouter un utilisateur</h3>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-5">
                    <div class="fv-row mb-5 w-100 flex-md-root">
                        <label class="required form-label">Nom</label>
                        <input type="text" name="first_name" class="form-control mb-3 mb-lg-0" placeholder="Nom"/>
                    </div>
                    <div class="fv-row mb-5 w-100 flex-md-root">
                        <label class="required form-label">Prenom</label>
                        <input type="text" name="last_name" class="form-control mb-3 mb-lg-0" placeholder="Prénom"/>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-5">
                    <div class="fv-row mb-5 w-100 flex-md-root">
                        <label class="form-label">Dépôt </label>
                        <select class="form-select" data-control="select2" data-placeholder="Aucun(e) sélection" name="entite_id">
                            <option value="">Aucun(e)</option>
                            @foreach ($depots as $depot)
                                <option value="{{ $depot->id }}">{{ $depot->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-5 fv-row">
                    <label class="required form-label">Role</label>
                    <select class="form-select" data-control="select2" data-placeholder="Sélectionner un rôle" name="roles[]" id="role_form_select">
                        <option></option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                {{--  <div class="fv-row mb-5">
                    <label class="fw-semibold fs-6 mb-2">Nom utilisateur</label>
                    <input type="text" name="user_name" class="form-control mb-3 mb-lg-0" placeholder="Saisir le nom d'utilisateur"/>
                </div>  --}}
                <div class="fv-row mb-5">
                    <label class="fw-semibold fs-6 mb-2">Adresse email</label>
                    <input type="email" name="email" class="form-control mb-3 mb-lg-0" placeholder="Saisir e-mail de l'utilisateur"/>
                </div>
                <div class="fv-row mb-5 w-100 flex-md-root">
                    <label class="required form-label">Mot de passe</label>
                    <input type="password" autocomplete="new-password" name="password" class="form-control mb-3 mb-lg-0" placeholder="Mot de passe"/>
                </div>
                <div class="fv-row w-100 flex-md-root">
                    <label class="required form-label">Confirmer le  mot de passe</label>
                    <input type="password" autocomplete="new-password" name="password_confirmation" class="form-control mb-3 mb-lg-0" placeholder="Confirmer le  mot de passe"/>
                </div>
            </div>
            <div class="card-footer ">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" id="btn_add_user_form" class="btn btn-primary">
                        <span class="indicator-label">ENREGISTRER</span>
                        <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</x-default-layout>
