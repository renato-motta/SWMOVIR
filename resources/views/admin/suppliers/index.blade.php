<x-admin-layout
    title='Proveedores'
    :breadcrumbs="[   
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Proveedores',
    ]
]">

    @push('css')
        <style>
            table th span, table td {
                font-size: 0.75rem !important;
            }
        </style>
    @endpush

    <x-slot name="action">
        <x-wire-button href="{{route('admin.suppliers.import')}}" green >
            <i class="fas fa-file-import"></i>Importar
        </x-wire-button>
        <x-wire-button href="{{route('admin.suppliers.create')}}" blue >
            <i class="fas fa-plus"></i>Nuevo
        </x-wire-button>
    </x-slot>

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.datatables.supplier-table') 

</x-admin-layout>