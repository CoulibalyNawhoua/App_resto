<td class="text-end">
    <a href="#" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
        <i class="ki-duotone ki-gear fs-1">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>
    </a>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" style="">
        @if($order_status == 1)
            <div class="menu-item px-3">
                <a href="{{ route('orders.deposit.view', $reference) }}"  class="menu-link px-3"><i class="bi bi-eye pe-2"></i>Aperçu</a>
            </div>
        @endif
        @if($order_status == 2)
            <div class="menu-item px-3">
                <a href="{{ route('orders.delivery.create', $reference) }}" class="menu-link px-3"><i class="bi bi-file-earmark-plus pe-2"></i>Livraison</a>
            </div>
        @endif

        <div class="menu-item px-3">
            <a href="{{ route('orders.print', $reference) }}" target="_blank" class="menu-link px-3"><i class="bi bi-filetype-pdf pe-2"></i> Commande en pdf</a>
        </div>
    </div>
</td>
