<x-admin-layout
    title='Usuarios'
    :breadcrumbs="[
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Usuarios',
    ]
]">

    {{-- <x-slot name="action">
        <x-wire-button href="{{route('admin.users.import')}}" blue >
            <i class="fas fa-file-import"></i>
            Importar
        </x-wire-button>
    </x-slot> --}}

    <x-slot name="action">
        <x-wire-button href="{{route('admin.users.create')}}" blue >
            <i class="fas fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.datatables.user-table')

</x-admin-layout>
