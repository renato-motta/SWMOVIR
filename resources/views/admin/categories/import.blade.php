<x-admin-layout
    title='Categorias'
    :breadcrumbs="[ 
    [
        'name'=>'Dashboards',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Categorias',
        'href'=> route('admin.categories.index'),                                           
    ],
    
    [  
        'name'=>'Importar'
    ]
]">

    {{-- este componente livewire es  para renderizar  --}}
    @livewire('admin.import-of-categories')
</x-admin-layout>