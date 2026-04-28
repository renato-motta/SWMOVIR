<x-admin-layout
    title='Almacenes'
    :breadcrumbs="[ 
    [
        'name'=>'Dashboards',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Almacenes',
        'href'=> route('admin.warehouses.index'),                                           
    ],
    
    [  
        'name'=>'Importar'
    ]
]">

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.import-of-warehouses')
</x-admin-layout>