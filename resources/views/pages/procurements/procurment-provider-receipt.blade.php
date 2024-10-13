<x-default-layout>
    <div class="card shadow-sm mt-10">
        <div class="card-header">
            <h3 class="card-title">Gestion réception</h3>
            <div class="card-toolbar">

            </div>
        </div>
        <div class="card-body">
            <table id="ajax-datatable-procurement-receipt" class="table table-rounded border gy-7 gs-7">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>#</th>
                        <th>Date</th>
                        <th>Référence</th>
                        <th>Fournisseur</th>
                        <th>Commande</th>
                        <th>Montant réception</th>
                        {{--<th>Statut</th>--}}
                        <th>Date création</th>
                        <th>Auteur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</x-default-layout>
