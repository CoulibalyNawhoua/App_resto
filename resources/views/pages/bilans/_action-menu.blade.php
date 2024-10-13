<td class="text-end">
    <a href="#" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
        <i class="ki-duotone ki-gear fs-1">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>
    </a>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-250px py-4" data-kt-menu="true" style="">
        @can('supprimer_bilan')
            <div class="menu-item px-3">
                <a href="javascript:;" onclick="deleteFunction({{$id}},'bilan-recette-product-delete','ajax-datatable-bilan-recette-product')" class="menu-link px-3" >Supprimer</a>
            </div>
        @endcan

        @can('afficher_bilan')
            <div class="menu-item px-3">
                <a href="{{ route('bilan-produit-recette-view',$reference) }}" class="menu-link px-3" >Aperçu</a>
            </div>
        @endcan

        @can('valider_bilan')
            @if ($status == 0)
                <div class="menu-item px-3">
                    <a href="{{ route('bilan-produit-recette-validate',$reference) }}" class="menu-link px-3" >Valider</a>
                </div>
            @endif
        @endcan
    </div>
</td>
