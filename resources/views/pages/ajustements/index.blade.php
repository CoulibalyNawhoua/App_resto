<x-default-layout>
    <div class="card shadow-sm mt-10">
        <!--begin::Card header-->
        <div class="card-header">
            <h3 class="card-title">AJUSTEMENT DES STOCKS <span class="me-5"></span><span id="depot_stockage" class="mr-2 badge badge-square p-2 badge-primary"> @if(Auth::user()->entite())  {{ Auth::user()->entite->name }} @endif</span></h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-info btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>	Exporter
                </button>

                <div id="kt_datatable_example_export_menu" data-kt-menu="true" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4">

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="copy">
                            Copier dans le presse-papier
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="excel">
                            Exporter en excel
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="csv">
                            Exporter en CSV
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-export="pdf">
                            Exporter en PDF
                        </a>
                    </div>
                </div>
                <div id="kt_datatable_example_buttons" class="d-none"></div>
            </div>
        </div>
        <div class="card-body pt-10">
            <div class="table-responsive">
                <table id="ajax-datatable-ajustment" class="table table-rounded border gy-7 gs-7">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                            <th>#</th>
                            <th>Réference</th>
                            <th>Site</th>
                            <th>Produit</th>
                            <th>Unité stockage</th>
                            <th>Quantité initiale</th>
                            <th>Quantité ajustée</th>
                            <th>Nouvelle quantité</th>
                            <th>Opération</th>
                            {{--  <th>Type opération</th>  --}}
                        {{-- <th>Action sur le stock</th>--}}
                            <th>Date création</th>
                            <th>Créer par</th>
                            {{--  <th>Actions</th>  --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</x-default-layout>
