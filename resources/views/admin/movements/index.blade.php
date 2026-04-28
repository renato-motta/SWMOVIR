<x-admin-layout
    title='Entradas y Salidas'
    :breadcrumbs="[  
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Entradas y Salidas',
    ]
]">

    <x-slot name="action">
        <x-wire-button href="{{route('admin.movements.create')}}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.datatables.movement-table')

</x-admin-layout>