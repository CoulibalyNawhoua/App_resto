<x-default-layout>

    {{--<form action="" method="post">
        @csrf--}}
        <div class="card shadow-sm mt-10">
            <div class="card-header">
                <div class="card-title">
                    <h2>Détails commande</h2>
                </div>
            </div>
            <div class="card-body pt-10">
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label for="" class="form-label">Dépôt émetteur</label>
                        <input class="form-control rounded-0" disabled value="{{  $order->entite->name  }}"/>
                    </div>
                    <div class="fv-row mb-3 col-md-3">
                        <label class="form-label">Date commande</label>
                        <input class="form-control rounded-0" name="order_date" disabled value="{{  Date::parse($order->order_date)->locale('fr')->format('l jS F Y')  }}"/>
                    </div>
                </div>

                <div class="row">
                    <div class="fv-row col-md-6">
                        <label for="" class="form-label">Note</label>
                        <textarea class="form-control rounded-0" id="note_id" name="note" rows="3" placeholder="Tapez votre message ici"></textarea>
                        <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
                    </div>
                </div>

                <div class="table-responsive  mt-10">
                    <table  class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                        <thead class="bg-secondary text-align-center">
                            <tr class="fw-bold fs-6 text-gray-800 " >
                                <th class="w-500px">produit</th>
                                <th class="w-500px">Unité</th>
                                <th class="w-500px">Quantité commandée </th>
                                <th class="w-500px">Quantité livrée </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderProducts as $item)
                                <tr>
                                    <td class="w-500px">{{ $item->produit->nom_produit }}</td>
                                    <td class="w-500px">{{ $item->produit->unite->name }}</td>
                                    <td class="w-500px">{{ $item->quantity }}</td>
                                    <td class="w-500px">{{ $item->quantity_delivered }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-10">
            <button type="submit" id="accept-order-process" data-redirect="{{ route('orders.deposit.index') }}"  class="btn btn-success me-5">
                <span class="indicator-label">Accepté </span>
                <span class="indicator-progress">Veuillez patienter.....
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>

            <button type="submit" id="cancel-order-process" data-redirect="{{ route('orders.deposit.index') }}" class="btn btn-danger">
                <span class="indicator-label">Annulé </span>
                <span class="indicator-progress">Veuillez patienter.....
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    {{--</form>--}}
</x-default-layout>
