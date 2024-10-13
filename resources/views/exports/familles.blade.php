<table>
    <thead>
    <tr>
        <th style="text-align: center" colspan="4">LSITE FAMILLES</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Libelle</th>
        <th>Date de création</th>
        <th>Auteur</th>
    </tr>
    @foreach($familles as $famille)
        <tr>
            <td>{{ $famille->name }}</td>
            <td>{{ \Jenssegers\Date\Date::parse($famille->add_date)->locale('fr')->format('l j F Y H:m:s') }} </td>
            <td>{{ $famille->auteur->first_name }} {{ $famille->auteur->last_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
