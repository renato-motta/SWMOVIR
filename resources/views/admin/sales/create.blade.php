<x-admin-layout
    title='Ventas'
    :breadcrumbs="[
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Compras',
        'href'=>route('admin.sales.index'),
    ] ,
    [
        'name'=>'Nuevo',
    ]
]">

    @livewire('admin.sale-create')
</x-admin-layout> 