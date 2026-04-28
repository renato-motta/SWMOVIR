<x-admin-layout
    title='Usuarios'
    :breadcrumbs="[
    [
        'name'=>'Dashboard',
        'href'=> route('admin.dashboard'),                                           
    ],
    [
        'name'=>'Usuarios',
        'href'=>route('admin.users.index'),
    ],
    [
        'name'=>'Editar',
    ]
]">

<x-wire-card>
        <h1 class="text-2xl font-semibold mb-4">
            Editar Usuario
        </h1>
        
        <form action="{{route('admin.users.update', $user)}}" method="POST" >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <x-wire-input label="Nombre" name="name" placeholder="Nombre del usuario" value="{{old('name', $user->name)}}" required>
                </x-wire-input>

                <x-wire-input label="Email" name="email" type="email" placeholder="Ingrese su correo electronico" value="{{old('email',$user->email)}}" required>
                </x-wire-input>

                <x-wire-input label="Contraseña" name="password" type="password" placeholder="Ingrese su contraseña" >
                </x-wire-input>

                <x-wire-input label="Confirmar Contraseña" name="password_confirmation" type="password" placeholder="Confirma la contraseña del usuario" >
                </x-wire-input>
            </div>
           
            <div class="flex justify-end mt-4">
                <x-wire-button type="submit" blue>
                    Actualizar
                </x-wire-button>
            </div>
        
        </form>
    </x-wire-card>
</x-admin-layout>