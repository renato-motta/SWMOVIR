<x-admin-layout
    title='Proveedores'
    :breadcrumbs="[ 
    [
        'name'=>'Dashboards',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Proveedores',
        'href'=> route('admin.suppliers.index'),                                           
    ],
    
    [  
        'name'=>'Importar'
    ]
]">

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.import-of-suppliers')
</x-admin-layout>