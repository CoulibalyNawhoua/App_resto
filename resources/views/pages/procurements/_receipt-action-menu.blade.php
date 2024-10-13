<td class="text-end">
    <a href="#" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
        <i class="ki-duotone ki-gear fs-1">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>
    </a>
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">

        <div class="menu-item px-3">
            <a href="{{ route('procurments.providers.receipt.view', $reception_ref)}}"   class="menu-link px-3">
                Aperçu
            </a>
        </div>

        @can('supprimer_reception_achat')
            <div class="menu-item px-3">
                <a href="javascript:;" onclick="deleteFunction({{ $id }},'receipt-delete','ajax-datatable-procurement-receipt')"  class="menu-link px-3">
                    Supprimer
                </a>
            </div>
        @endcan

        <!--end::Menu item-->

        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="{{ route('procurments.providers.receipt.print', $id) }}" target="_blank" class="menu-link px-3">
                Imprimer en PDF
            </a>
        </div>
        <!--end::Menu item-->

    </div>
    <!--end::Menu-->
</td>
