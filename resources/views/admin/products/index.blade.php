<x-admin-layout
    title='Productos'
    :breadcrumbs="[ 
    [
        'name'=>'Dashboards',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Productos',
    ]
]">

    @push('css')
        <style>
            table th span, table td {
                font-size: 0.75rem !important;
            }

            .image-product {
                width: 5rem !important; 
                height: 3rem !important;
                object-fit: cover !important;
                object-position: center !important;
            }
        </style>
    @endpush

    <x-slot name="action">
        <x-wire-button href="{{route('admin.products.import')}}" green >
            <i class="fas fa-file-import"></i>Importar
        </x-wire-button>
        <x-wire-button href="{{route('admin.products.create')}}" blue >
            <i class="fas fa-plus"></i>Nuevo
        </x-wire-button>
    </x-slot>

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.datatables.product-table')

    
</x-admin-layout>