<td class="text-end">
    <a href="#" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
        <i class="ki-duotone ki-gear fs-1">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>
    </a>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" style="">
        <div class="menu-item px-3">
            <a href="{{ route('procurments.providers.view', $reference) }}"  class="menu-link px-3">Aperçu</a>
        </div>

        <div class="menu-item px-3">
            <a href="{{ route('procurments.providers.print', $id) }}" target="_blank" class="menu-link px-3">Commande en PDF</a>
        </div>

        @can('modifier_achat')
            @if($procurment_status == 0)
                <div class="menu-item px-3">
                    <a href="{{ route('procurments.providers.edit', $reference) }}" class="menu-link px-3">Modifier</a>
                </div>
            @endif
        @endcan


       {{-- <div class="menu-item px-3">
            <a href="javascript:;" onclick="deleteFunction({{ $id }},'entite-delete','ajax-datatable-entite')" class="menu-link px-3" >Supprimer</a>
        </div>--}}

        @can('ajouter_reception_achat')
            @if($procurment_status == 1)
                <div class="menu-item px-3">
                    <a href="{{ route('procurments.providers.receipt.create', $id) }}" class="menu-link px-3">Réceptionner</a>
                </div>
            @endif
        @endcan

    </div>
</td>
