<x-default-layout>
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10 mt-10">
            <div class="row mb-5">
                <div class="col-md-8">
                    <div class="card shadow-sm mb-1">
                        <div class="card-header">
                            <h3 class="card-title">Gestion réception</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    <div class="mb-5 fv-row col-md-6">
                                        <label class="required form-label">Dépôt stockage</label>
                                        <input class="form-control rounded-0"  disabled value="{{ $procurement->depotStockage->name }}">
                                    </div>
                                    <div class="fv-row col-md-3">
                                        <label class="form-label">Date réception</label>
                                        <input class="form-control rounded-0" disabled  value="{{ Date::parse($reception->reception_date)->format('Y-m-d') }}"/>
                                    </div>
                                    <div class="fv-row col-md-3">
                                        <label class="form-label">Référence facture</label>
                                        <input class="form-control rounded-0" disabled value="{{ $reception->invoice_reference }}"/>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="fv-row col-md-12">
                                        <label class="form-label">Commentaire</label>
                                        <textarea  class="form-control rounded-0" disabled rows="2">{{ $reception->note }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="fv-row col-md-4">
                                        <label class="form-label">Date de création</label>
                                        <input class="form-control rounded-0" disabled  value="{{ Date::parse($reception->created_at)->format('l j F Y H:m:s') }}"/>
                                    </div>
                                    <div class="fv-row col-md-2">
                                        <label class="form-label">Statut</label>
                                        <p>
                                            @if($reception->receipt_status == 1)
                                                <span class="ms-2 py-3 px-4 fs-7 badge badge-info fw-bold">Accepté</span>
                                            @endif

                                            @if($reception->receipt_status == 0)
                                                <span class="ms-2 py-3 px-4 fs-7 badge badge-danger fw-bold">Annulé</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Resumé de la commande</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column mw-md-300px w-100">

                                <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                    <div class="fw-semibold pe-5">Date commande:</div>
                                    <div class="text-end fw-norma">{{ Date::parse($procurement->date_commande)->locale('fr')->format('l j F Y') }}</div>
                                </div>
                                <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                    <div class="fw-semibold pe-5">Montant TTC:</div>
                                    <div class="text-end fw-norma">{{ number_format($procurement->cost) }} FCFA</div>
                                </div>
                                <div class="d-flex flex-stack text-gray-800 mb-3 fs-6">
                                    <div class="fw-semibold pe-5">Fournisseur:</div>
                                    <div class="text-end fw-norma">{{ $procurement->fournisseur->nom }} {{ $procurement->fournisseur->prenom }}</div>
                                </div>
                                <div class="d-flex flex-stack text-gray-800 fs-6 mb-3">
                                    <div class="fw-semibold pe-5">Reférence:</div>
                                    <div class="text-end fw-norma">{{ $procurement->reference }}</div>
                                </div>
                                <div class="d-flex flex-stack text-gray-800 fs-6">
                                    <div class="fw-semibold pe-5">Statut commande:</div>
                                    <div class="text-end fw-norma">
                                        @if($procurement->procurment_status == 0)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-info fw-bold">Validation en attente</span>
                                        @endif

                                        @if($procurement->procurment_status == 1)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-warning fw-bold">Réception en cours</span>
                                        @endif

                                        @if($procurement->procurment_status == 2)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-success fw-bold">Clôturée</span>
                                        @endif

                                        @if($procurement->procurment_status == 3)
                                            <span class="ms-2 py-3 px-4 fs-7 badge badge-danger fw-bold">Annulée</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="card shadow-sm">
              <div class="card-body pb-10">
                <div class="table-responsive">
                    <table   class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th class="w-300px">Produit</th>
                                <th class="w-200px">Unité</th>
                                <th class="w-200px">Qté commandée</th>
                                <th class="w-200px">Qté réceptionnée</th>
                                <th class="w-200px">Prix achat</th>
                                <th class="w-200px">Prix total</th>
                            </tr>
                        </thead>
                        <tbody id="tabpanier-id" >
                            @foreach ($reception->produitReceptions as $item)
                                <tr>
                                    <td class="w-300px">{{ $item->produit->nom_produit }}</td>
                                    <td class="w-300px">{{ $item->product_unit->unite->name }}</td>
                                    <td class="w-200px">{{ number_format($item->quantity) }}</td>
                                    <td class="w-200px">{{ number_format($item->quantity_received) }}</td>
                                    <td class="w-200px">{{ number_format($item->unit_price) }}</td>
                                    <td class="w-200px sous-total">{{ number_format($item->quantity_received * $item->unit_price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="w-200px text-lg-end" colspan="5">Total</td>
                            <td class="w-200px">
                                {{ number_format($reception->total_receipt_price) }}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
              </div>
           </div>
           <div class="d-flex justify-content-end mt-2">
               @if($reception->receipt_status == 1)
                   <button type="submit" data-receipt="{{ $reception->id }}" id="cancel-receipt-process" data-redirect="{{ route('procurments.providers.receipt') }}" class="btn btn-danger">
                       <span class="indicator-label">Annulé</span>
                       <span class="indicator-progress">Veuillez patienter...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                   </button>
               @endif

           </div>
        </div>
</x-default-layout>
