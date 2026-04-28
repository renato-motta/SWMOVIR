<x-admin-layout
    title='Productos'
    :breadcrumbs="[   
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Productos',
        'href'=>route('admin.products.index'),
    ] ,
    [
        'name'=>'Nuevo',
    ]
]">


    <x-wire-card>
        <form action="{{route('admin.products.store')}}" method="POST"class="space-y-4">
            @csrf
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del producto" value="{{old('name')}}">
            </x-wire-input>

            <x-wire-textarea label="Descripción" name="description" placeholder="Descripción del producto">
                {{old('description')}}
            </x-wire-textarea>

            <x-wire-input type="number" label="Precio" name="price" placeholder="Precio del producto" value="{{old('price')}}" min="0.01" step="0.01" >
            </x-wire-input>

            <x-wire-native-select label="Categoría" name="category_id" >
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" @selected(old('category_id')==$category->id)>
                        {{$category->name}}
                    </option>
                @endforeach
            </x-wire-native-select>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        
        </form>
    </x-wire-card>

   
</x-admin-layout> 