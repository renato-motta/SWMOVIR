<x-admin-layout
    title='Proveedores'
    :breadcrumbs="[   //props pasar info a un componente, es recibirlo desde el componente
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Proveedores',
        'href'=>route('admin.suppliers.index'),
    ] ,
    [
        'name'=>'Editar',
    ]
]">

    <x-wire-card>
        <form action="{{route('admin.suppliers.update', $supplier)}}" method="POST"class="space-y-4">
            
            @csrf
            @method('PUT')

                <x-wire-native-select label="Tipo de documento" name="identity_id">
                    @foreach ($identities as $identity)
                        <option value="{{$identity->id}}" @selected(old('identity_id', $supplier->identity_id)==$identity->id)>
                            {{$identity->name}} 
                        </option>
                    @endforeach
                </x-wire-native-select>

            <x-wire-input label="Número de documento" name="document_number" placeholder="Nombre del documento" value="{{old('document_number',$supplier->document_number)}}">
            </x-wire-input>

            <x-wire-input label="Nombre" name="name" placeholder="Nombre del proveedor" value="{{old('name',$supplier->name)}}">
            </x-wire-input>

            <x-wire-input label="Dirección" name="address" placeholder="Dirección del proveedor" value="{{old('address',$supplier->address)}}">
            </x-wire-input>

            <x-wire-input label="Email" name="email" placeholder="Correo electronico del proveedor" value="{{old('email',$supplier->email)}}">
            </x-wire-input>

            <x-wire-input label="Teléfono" name="phone" placeholder="Teléfono del proveedor" value="{{old('phone',$supplier->phone)}}">
            </x-wire-input>
            
            <div class="flex justify-end">
                <x-button>
                    Actualizar
                </x-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout> 