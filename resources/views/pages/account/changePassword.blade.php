<x-default-layout>
    <form action="{{ route('settings-password-change-store') }}" id="kt_signin_change_password" method="post">
        @csrf
        <div class="card shadow-sm mt-10">
        <div class="card-header">
            <h3 class="card-title">Modifier votre mot de passe</h3>
            <div class="card-toolbar">

            </div>
        </div>
        <div class="card-body">
            <div class="mb-5 fv-row">
                <label class="form-label">Mot de passe actuel</label>
                <input type="password" class="form-control" name="current_password"  autocomplete="current-password">
            </div>
            <div class="mb-5 fv-row">
                <label class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control" name="new_password"  autocomplete="current-password">
            </div>
            <div class="mb-5 fv-row">
                <label class="form-label">Nouveau mot de passe de confirmation</label>
                <input type="password" class="form-control" name="new_confirm_password"  autocomplete="current-password">
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end mt-10">
                <button type="submit" id="kt_password_submit" class="btn btn-primary">
                    <span class="indicator-label">ENREGISTRER</span>
                    <span class="indicator-progress">Veuillez patienter.....
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
    </form>
</x-default-layout>
