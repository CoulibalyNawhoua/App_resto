<td>
    @if ($delivery_status == 0)
        <span class="badge py-3 px-4 fs-7 badge-light-warning">En attente</span>
    @endif

    @if($delivery_status == 1)
        <span class="badge py-3 px-4 fs-7 badge-light-primary">Crée</span>
    @endif

    @if($delivery_status == 2)
            <span class="badge py-3 px-4 fs-7 badge-light-info">Expédié</span>
    @endif

</td>
