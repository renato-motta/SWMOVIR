<x-admin-layout
    title='Productos'
    :breadcrumbs="[ 
    [
        'name'=>'Dashboards',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Productos',
        'href'=> route('admin.products.index'),                                           
    ],
    
    [  
        'name'=>'Importacion'
    ]
]">
    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.import-of-products')
</x-admin-layout>