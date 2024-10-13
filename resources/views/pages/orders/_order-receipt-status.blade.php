<td>
    @if ($receipt_status == 0)
        <span class="badge py-3 px-4 fs-7 badge-light-primary">En attente</span>
    @endif

    @if ($receipt_status == 1)
        <span class="badge py-3 px-4 fs-7 badge-light-success">Accepter</span>
    @endif

    @if ($receipt_status == 2)
        <span class="badge py-3 px-4 fs-7 badge-light-danger">Annuler</span>
    @endif

</td>
