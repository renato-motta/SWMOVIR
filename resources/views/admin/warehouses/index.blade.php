<x-admin-layout
    title='Almacenes'
    :breadcrumbs="[
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Almacenes',
    ]
]">

    <x-slot name="action">
        <x-wire-button href="{{route('admin.warehouses.import')}}" green >
            <i class="fas fa-file-import"></i>Importar
        </x-wire-button>
        <x-wire-button href="{{route('admin.warehouses.create')}}" blue >
            <i class="fas fa-plus"></i>Nuevo
        </x-wire-button>
    </x-slot>

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.datatables.warehouse-table')
    
</x-admin-layout>