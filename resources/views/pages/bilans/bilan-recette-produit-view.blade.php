<x-default-layout>

    @if ($bilan->status == 0)
        <div class="card card-bordered mt-10">
            <div class="card-header">
                <h3 class="card-title">APERÇU BILAN {{ $bilan->reference }} DU {{ $bilan->created_at }}</h3>
                <div class="card-toolbar">
                    <a href="{{ route('export-bilan',$bilan->reference) }}" class="btn btn-info btn-sm">
                        <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>	Exporter
                    </a>
                    {{--  <button type="button" class="btn btn-info btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                    <div id="kt_datatable_example_buttons" class="d-none"></div>  --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th class="fw-bold">PRODUIT</th>
                                <th class="fw-bold">UNITÉ</th>
                                <th class="fw-bold">QUANTITÉ</th>
                                <th class="fw-bold">QUANTITÉ TOTALE UTILISÉE</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bilan_recettes as $data)
                                <tr>
                                    <td colspan="4" class="text-bg-info" style="text-align: left;">{{ $data->recette->name }} (Ventes du jour: {{ $data->quantity }})</td>
                                </tr>

                                @foreach ($data->recette->fichesTechniques as $item)
                                    <tr>
                                        <td>{{ $item->produit->nom_produit }}</td>
                                        <td>{{ $item->groupeUnite->name }}</td>
                                        <td>{{ number_format($item->quantity) }}</td>
                                        <td>{{ number_format($data->quantity * $item->quantity) }} {{ $item->groupeUnite->name  }}</td>
                                    </tr>
                                @endforeach

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
    <div class="card card-bordered mt-10">
        <div class="card-header">
            <h3 class="card-title">APERÇU BILAN {{ $bilan->reference }} DU {{ $bilan->created_at }}</h3>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800">
                            <th>#</th>
                            <th>Réference</th>
                            <th>Site</th>
                            <th>Produit</th>
                            <th>Unité stockage</th>
                            <th>Quantité initiale</th>
                            <th>Quantité utilisée</th>
                            <th>Nouvelle quantité</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($bilan->bilan_products)
                            @foreach ($bilan->bilan_products as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bilan->reference }}</td>
                                <td>{{ $data->site->name }}</td>
                                <td>{{ $data->product->nom_produit }}</td>
                                <td>{{ $data->product_unit->name }}</td>
                                <td>{{ $data->before_quantity }} {{ $data->product_unit->name }}</td>
                                <td>{{ $data->quantity }}</td>
                                <td>{{ $data->after_quantity }}</td>
                            </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</x-default-layout>
