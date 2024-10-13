<td>
    @if ($order_status == 0)
        <span class="badge py-3 px-4 fs-7 badge-light-info">Crée</span>
    @endif

    @if($order_status == 1)
        <span class="badge py-3 px-4 fs-7 badge-light-primary">Expédié</span>
    @endif

    {{--@if($order_status == 2)
            <span class="badge py-3 px-4 fs-7 badge-light-danger">Annulée</span>
    @endif

    @if($order_status == 3)
        <span class="badge py-3 px-4 fs-7 badge-light-success">Approuvée</span>
    @endif
--}}
</td>
