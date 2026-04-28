<x-admin-layout
    title='Roles'
    :breadcrumbs="[
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Roles',
    ]
]">
<x-slot name="action">
        <x-wire-button href="{{route('admin.roles.create')}}" orange>
            Nuevo
        </x-wire-button>
</x-slot>
@livewire('admin.datatables.role-table')

</x-admin-layout>
