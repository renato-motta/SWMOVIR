<x-admin-layout
    title='Transferencias'
    :breadcrumbs="[  
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Transferencias',
    ]
]">

    <x-slot name="action">
        <x-wire-button href="{{route('admin.transfers.create')}}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.datatables.transfer-table')

</x-admin-layout>