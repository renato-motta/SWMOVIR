<x-admin-layout
    title='Roles'
    :breadcrumbs="[
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Usuarios',
        'href'=>route('admin.roles.index'),
    ],
    [
        'name'=>'Detalle',
    ]
]">

   
</x-admin-layout>