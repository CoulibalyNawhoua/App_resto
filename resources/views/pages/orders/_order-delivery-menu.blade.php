
<td class="text-end">
    <a href="#" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
        <i class="ki-duotone ki-gear fs-1">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>
    </a>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" style="">

        <div class="menu-item px-3">
            <a href="{{ route('order.delivery.print', $delivery_reference) }}"  target="_blank" class="menu-link px-3">Imprimer pdf</a>
        </div>

        @if($delivery_status == 1)
            <div class="menu-item px-3">
                <a href="javascript:;" onclick="functionSenderAction({{$id}},'delivery-order-send','ajax-datatable-order-delivery')" class="menu-link text-success px-3" >Livré</a>
            </div>
        @endif

       {{-- @if($delivery_status == 1 || $delivery_status== 2)
            <div class="menu-item px-3">
                --}}{{--<a href="javascript:;" onclick="refundDeliveryFunction({{$id}}, {{$delivery_reference}})" class="menu-link text-danger px-3" >Annuler</a>--}}{{--
                <a href="{{ route('order.delivery.view', $delivery_reference) }}"  class="menu-link text-danger px-3" >Annuler</a>
            </div>
        @endif--}}

    </div>
</td>
