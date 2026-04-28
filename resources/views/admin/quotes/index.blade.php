<x-admin-layout
    title='Cotizaciones'
    :breadcrumbs="[  
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Cotizaciones',
    ]
]">

    <x-slot name="action">
        <x-wire-button href="{{route('admin.quotes.create')}}" blue >
            Nuevo
        </x-wire-button>
    </x-slot>

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.datatables.quote-table')

</x-admin-layout>