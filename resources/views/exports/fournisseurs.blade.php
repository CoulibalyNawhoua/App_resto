<table>
    <thead>
    <tr>
        <th style="text-align: center" colspan="6">LSITE FOURNISSEURS</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Téléphone</th>
        <th>Adresse</th>
        <th>Date création</th>
        <th>Auteur</th>
    </tr>
    @foreach($fournisseurs as $fournisseur)
        <tr>
            <td>{{ $fournisseur->nom }}</td>
            <td>{{ $fournisseur->prenom }}</td>
            <td>{{ $fournisseur->phone }}</td>
            <td>{{ $fournisseur->address }}</td>
            <td>{{ \Jenssegers\Date\Date::parse($fournisseur->add_date)->locale('fr')->format('l j F Y H:m:s') }} </td>
            <td>{{ $fournisseur->auteur->first_name }} {{ $fournisseur->auteur->last_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
