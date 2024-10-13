<x-default-layout>
    <div class="card shadow-sm mt-10">
        <div class="card-header">
            <h3 class="card-title">Achat fournisseur</h3>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="fv-row col-md-3">
                    <label class="form-label">Fournisseur commande</label>
                    <input class="form-control rounded-0" disabled value="{{ $procurment->fournisseur->nom }} {{ $procurment->fournisseur->prenom }}" />
                </div>

                <div class="fv-row col-md-3">
                    <label class="form-label">Date commande</label>
                    <input class="form-control rounded-0" disabled value="{{ Date::parse($procurment->date_commande)->format('Y-m-d') }}"  id="date_commande_id"/>
                </div>

                <div class="fv-row col-md-3">
                    <label class="form-label">Date réception</label>
                    <input class="form-control rounded-0" value="{{ Date::parse($procurment->date_prevue_reception)->format('Y-m-d')  }}" disabled id="date_reception_id"/>
                </div>

            </div>

            <div class="row">
                <div class="fv-row col-md-3">
                    <label class="form-label">Référence n°</label>
                    <input class="form-control rounded-0" value="{{ $procurment->reference }}" disabled id="date_reception_id"/>
                </div>
                <div class="fv-row col-md-3">
                    <label class="form-label">Dépôt stockage</label>
                    <input class="form-control rounded-0" disabled value="{{ $procurment->depotStockage->name }}"/>
                </div>
                <div class="fv-row col-md-6">
                    <label class="form-label">Statut</label>
                    <p>
                        @if($procurment->procurment_status == 0)
                            <span class="ms-2 py-3 px-4 fs-7 badge badge-info fw-bold">Validation en attente</span>
                        @endif

                        @if($procurment->procurment_status == 1)
                                <span class="ms-2 py-3 px-4 fs-7 badge badge-warning fw-bold">Réception en cours</span>
                        @endif

                        @if($procurment->procurment_status == 2)
                                <span class="ms-2 py-3 px-4 fs-7 badge badge-success fw-bold">Livré</span>
                        @endif

                        @if($procurment->procurment_status == 3)
                                <span class="ms-2 py-3 px-4 fs-7 badge badge-danger fw-bold">Annulé</span>
                        @endif
                    </p>

                </div>
            </div>

            <div class="table-responsive mt-10">
                <table   class="table table-rounded table-row-bordered border gy-7 gs-7">
                    <thead class="bg-secondary text-align-center">
                        <tr class="fw-bold fs-6 text-gray-800 " >
                            <th class="w-500px">produit</th>
                            <th class="w-300px">Unité</th>
                            <th class="w-300px">Prix unitaire</th>
                            <th class="w-300px">Quantité</th>
                            <th class="w-300px">Prix total</th>
                        </tr>
                    </thead>
                    <tbody id="tabpanier-id" >

                        @foreach ($procurement_products as $item)
                            <tr>
                                <td class="w-500px">{{ $item->produit->nom_produit }}</td>
                                <td class="w-300px">{{ $item->product_unit->unite->name }}</td>
                                <td class="w-300px">{{ $item->quantity }}</td>
                                <td class="w-300px">{{ $item->purchase_price }}</td>
                                <td class="w-300px sous-total">{{ $item->total_purchase_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="w-500px"></td>
                        <td class="w-300px"></td>
                        <td class="w-300px"></td>
                        <td class="w-300px">Total</td>
                        <td class="w-300px">
                            {{ $procurment->cost }}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-10">

            @can('validation_achat')
                @if($procurment->procurment_status == 0)
                    <button data-procurement="{{ $procurment->id }}" data-redirect="{{ route('procurments.providers.index') }}"  type="button" id="accepted-procurement-process" class="btn btn-success">
                        <span class="indicator-label">Confirmé</span>
                        <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <button data-procurement="{{ $procurment->id }}" data-redirect="{{ route('procurments.providers.index') }}"  type="button" id="rejected-procurement-process" class="btn btn-danger">
                        <span class="indicator-label">Annulé </span>
                        <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                @endif
            @endcan

            @if($procurment->procurment_status == 1 && $procurment->procurment_status != 2)
                <button data-procurement="{{ $procurment->id }}" data-redirect="{{ route('procurments.providers.index') }}"  type="button" id="closed-procurement-process" class="btn btn-success">
                    <span class="indicator-label">Clôturée </span>
                    <span class="indicator-progress">Veuillez patienter.....
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            @endif
        </div>

</x-default-layout>
