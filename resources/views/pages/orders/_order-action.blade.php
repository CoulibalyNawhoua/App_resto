<td class="text-end">
    <a href="#" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
        <i class="ki-duotone ki-gear fs-1">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>
    </a>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" style="">

        @can('modifier_commande')
            @if ($order_status == 0)
                <div class="menu-item px-3">
                    <a href="{{ route('orders.edit', $reference) }}" class="menu-link px-3"><i class="bi bi-pencil-square pe-2"></i>Modifier</a>
                </div>
            @endif
        @endcan


        <div class="menu-item px-3">
            <a href="{{ route('orders.print', $reference) }}" target="_blank" class="menu-link px-3"><i class="bi bi-filetype-pdf pe-2"></i> Commande en pdf</a>
        </div>

        @can('supprimer_commande')
            @if($order_status == 0)
                <div class="menu-item px-3">
                    <a href="javascript:;" onclick="deleteFunction({{ $id }},'order-delete','ajax-datatable-order')" class="menu-link text-danger px-3" ><i class="bi bi-trash3 pe-2 text-danger"></i> Supprimer</a>
                </div>
            @endif
        @endcan

        @can('confirmer_commande')
            @if($order_status == 0)
                <div class="menu-item px-3">
                    <a href="javascript:;" onclick="functionConfirmOrder({{$id}},'order-validate','ajax-datatable-order')" class="menu-link text-success px-3"><i class="bi bi-send-check text-success pe-2"></i>Valider & Expédier</a>
                </div>
            @endif
        @endcan

        @can('ajouter_reception_commande')
            @if($order_status == 2)
                <div class="menu-item px-3">
                    <a href="{{ route('orders.receipt.create', $reference) }}"  class="menu-link px-3"><i class="bi bi-pen pe-2"></i> Réceptionner</a>
                </div>
            @endif
        @endcan

        @can('cloturer_commande')
            @if($order_status == 2)
                <div class="menu-item px-3">
                    <a href="javascript:;" onclick="functionCloseOrder({{$id}},'close-order','ajax-datatable-order')" class="menu-link text-success px-3"><i class="bi bi-check text-success pe-2"></i>clôturer la commande</a>
                </div>
            @endif
        @endcan
    </div>
</td>
