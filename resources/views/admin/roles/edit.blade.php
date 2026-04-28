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
        'name'=>'Editar',
    ]
]">

<x-wire-card>
    <h1 class="text-2xl font-semibold mb-4">Editar rol</h1>
    <form action="{{route('admin.roles.update',$role)}}" method="POST" class="space-y-4">
        {{-- COLOCAR EL TOKEN @csrf --}}
        @csrf
        @method('PUT')
        <x-wire-input label="Nombre de rol" name="name" placeholder="ejem: admin,editor,viewer" value="{{old('name',$role->name)}}" required>
        </x-wire-input>

        <div >
            <p class="block text-sm font-medium disabled:opacity-60 text-gray-700 dark:text-gray-400 invalidated:text-negative-600 dark:invalidated:text-negative-700">
                Permisos
            </p>

            <ul class="columns-1 md:columns-2 lg:columns-4 gap-4">
                @foreach ($permissions as $permission)
                    <li >
                        <label>
                            {{-- componente de jetstream --}}
                            <x-checkbox name="permissions[]" value="{{$permission->id}}" :checked="in_array($permission->id, old('permissions',$role->permissions->pluck('id')->toArray()))">
                            </x-checkbox>
                            <span class="text-sm text-gray-700 dark:text-gray-400">
                                {{$permission->name}}
                            </span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-end">
            <x-wire-button type="submit" orange >
                Editar rol
            </x-wire-button>
        </div>
    </form>

</x-wire-card>
</x-admin-layout>