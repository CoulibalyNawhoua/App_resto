<table>
    <thead>
        <tr>
            <th style="background-color: black; color:white">PRODUIT</th>
            <th style="background-color: black; color:white">UNITÉ</th>
            <th style="background-color: black; color:white">QUANTITÉ</th>
            <th style="background-color: black; color:white">QUANTITÉ TOTALE UTILISÉE</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($bilan_recettes as $data)
            <tr>
                <td colspan="4" style="font-weight: 900;">{{ $data->recette->name }} (Ventes du jour: {{ $data->quantity }})</td>
            </tr>

            @foreach ($data->recette->fichesTechniques as $item)
                <tr>
                    <td>{{ $item->produit->nom_produit }}</td>
                    <td>{{ $item->unite->name }}</td>
                    <td>{{ number_format($item->quantity) }}</td>
                    <td>{{ number_format($data->quantity * $item->quantity) }} {{ $item->unite->name  }}</td>
                </tr>
            @endforeach

        @endforeach
    </tbody>
</table>
