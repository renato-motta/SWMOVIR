<div>
    <x-wire-card>
        <h1 class="text-2xl font-semibold  text-gray-800 mb-6">Importar almacenes desde excel</h1>
        <x-wire-button blue wire:click="downloadTemplate">
            <i class="fas fa-file-excel"></i>
            Descargar plantilla
        </x-wire-button>
        <p class="text-sm text-gray-500 mt-1"> 
            Completa la plantilla con los datos de tus almacenes y súbela aquí 
        </p>
        
        <div class="mt-4">
            <input type="file" accept=".xlsx, .xls" wire:model="file">
            </input>
            <x-input-error for="file" class="mt-2">

            </x-input-error>
        </div>

        <div class="mt-4">
            <x-wire-button green wire:click="importWarehouses" wire:loading.attr="disabled" wire:target="file" spinner="importWarehouses">
                <i class="fas fa-upload mr-2"></i>
                Importar Almacenes
            </x-wire-button>
        </div>

        @if (count($errors))
            <div class="mt-4">
                <div class="p-4 bg-yellow-100 border border-yellow-300 rounded-md text-yellow-800 mb-3">
                    @if ($importedCount)
                        <i class="fas fa-triangle-exclamation mr-2"></i>
                        <strong>Importacion completada parcialmente</strong>
                        <p class="mt-1 text-sm">Algunos almacenes no se pudieron importar debido a errores.</p>
                    @else
                        <i class="fas fa-xmark mr-2"></i>
                        <strong>No se importo ningun almacén</strong>
                        <p class="mt-1 text-sm">Todos los almacenes tienen errores o el archivo no es válido</p>
                    @endif
                </div>

                <ul class="space-y-2">
                    @foreach ($errors as $error)
                        <li class="p-3 bg-red-50 border border-red-200 rounded-md">
                            <p class="text-red-700 font-semibold"> 
                                <i class="fas fa-file-pen"></i>
                                Fila {{$error['row']}}:
                            </p>

                            <ul class="list-disc list-inside mt-1">
                                @foreach ($error['errors'] as $message)
                                    <li class="text-red-600 text-sm">
                                        {{$message}}
                                    </li>
                                @endforeach

                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>    
        @endif
        
    </x-wire-card>
</div>

