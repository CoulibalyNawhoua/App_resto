function desactiverCompte(user_id){
    Swal.fire({
        title: "Êtes-vous sûr?",
        text: "Voulez-vous désactiver le compte de cet utilisateur?",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Valider",
        cancelButtonText: "Annuler",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                method:"POST",
                url: "/disabled-account/",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: { user_id: user_id },
                dataType: 'json',
                success: function(res){
                    Swal.fire({
                        text: "Le compte d’utilisateur a été desactivé.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-default"
                        }
                    });
                }
            });
        }
        else if (result.dismiss === "cancel") {
            $('#status_compte').prop('checked', true);
        }
    });
}


function activateAccount(user_id){

    Swal.fire({
        title: "Êtes-vous sûr?",
        text: "Voulez-vous activer le compte de cet utilisateur?",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Oui",
        cancelButtonText: "Non",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                method:"POST",
                url: "/activate-account/",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: { user_id: user_id },
                dataType: 'json',
                success: function(res){
                    Swal.fire({
                        text: "Le compte d’utilisateur a été activé.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-default"
                        }
                    });
                }
            });
        }
        else if (result.dismiss === "cancel") {
            $('#status_compte').prop('checked', false);
        }
    });
}


function statusCompteChange($parent_checkbox,user_id) {
    var checkBox = document.getElementById($parent_checkbox);
    if (checkBox.checked == true){
        activateAccount(user_id);
    } else {
        desactiverCompte(user_id);
    }

}
