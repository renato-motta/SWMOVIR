<x-admin-layout
    title='Ordenes de compra'
    :breadcrumbs="[  
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Ordenes de compra',
    ]
]">

    <x-slot name="action">
        <x-wire-button href="{{route('admin.purchase-orders.create')}}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.datatables.Purchase-order-table')

</x-admin-layout>