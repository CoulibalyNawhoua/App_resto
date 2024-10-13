<td class="text-end">
    <a href="#" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
        <i class="ki-duotone ki-gear fs-1">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>
    </a>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" style="">

        @can('supprimer_motif_gaspillage')
            <div class="menu-item px-3">
                <a href="javascript:;" onclick="deleteFunction({{ $id }},'motif-gaspillage-delete','ajax-datatable-operation')" class="menu-link px-3" >Supprimer</a>
            </div>
        @endcan
        @can('modifier_motif_gaspillage')
            <div class="menu-item px-3">
                <a href="javascript:;" onclick="editFunction({{ $id }})" class="menu-link px-3">Modifier</a>
            </div>
        @endcan
    </div>
</td>
