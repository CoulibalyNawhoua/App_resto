<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form  id="form" method="POST" action="{{ route('store-bilan-product-validate') }}" data-redirect="{{ route('bilan-produit-recette') }}" enctype="multipart/form-data">
        @csrf
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
                                <th class="fw-bold w-25px">INGRÉDIENT</th>
                                <th class="fw-bold w-25px">UNITÉ</th>
                                <th class="fw-bold w-25px">QUANTITÉ</th>
                                <th class="fw-bold w-25px">QUANTITÉ TOTALE UTILISÉE</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bilan_recettes as $data)
                                <tr>
                                    <td colspan="4" class="text-bg-info" style="text-align: center;">{{ $data->recette->name }} (Ventes du jour: {{ $data->quantity }})</td>
                                </tr>

                                @foreach ($data->recette->fichesTechniques as $item)
                                    <tr>
                                        <input type="hidden" name="products[]" value="{{ $item->produit->id }}">
                                        <td>{{ $item->produit->nom_produit }}</td>
                                        <td>
                                            <select name="unites[]" class="form-select h-30px p-1 rounded-0" required="">
                                                @foreach($item->produit->unite->groupsUnits as $unite)
                                                    <option value="{{ $unite->id }}" @if($unite->id == $item->groupe_unite_id) selected @endif  @if($unite->id != $item->groupe_unite_id) disabled @endif>{{ $unite->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text"  name="quantite[]" readonly class="form-control rounded-0 h-30px p-1 cout_product" value="{{ number_format($item->quantity) }}">
                                        </td>
                                        <td>
                                            <input type="text"  name="quantiteTotal[]" readonly class="form-control rounded-0 h-30px p-1 cout_product" value="{{ number_format($data->quantity * $item->quantity) }} ">
                                        </td>
                                    </tr>
                                @endforeach

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" id="btn-submit" class="btn btn-primary">
            <span class="indicator-label">ENREGISTRER</span>
            <span class="indicator-progress">Veuillez patienter...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
         </div>
         <input type="hidden" name="bilan_id" value="{{ $bilan->id }}">
    </form>
</x-default-layout>
