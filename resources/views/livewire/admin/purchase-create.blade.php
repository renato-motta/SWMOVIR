<div x-data="{
    products: @entangle('products'),

    total: @entangle('total'),

    removeProduct(index){
        this.products.splice(index,1);
    },

    init()
    {
        this.$watch('products', (newProducts)=>{

            let total=0;
            
            newProducts.forEach(product => {
                total += product.quantity * product.price;
            });
                this.total = total;
        });
    }
}">
    <x-wire-card>
        <form wire:submit="save" class="space-y-4">
            <div class="grid lg:grid-cols-4 gap-4">
                <x-wire-native-select label="tipo de comprobante" wire:model="voucher_type">
                    <option value="1">Factura</option>
                    <option value="2">Boleta</option>
                </x-wire-native-select>
                
                <div class="grid grid-cols-2 gap-2">
                    <x-wire-input label="Serie" wire:model="serie" placeholder="Serie de Comprobante">
                    </x-wire-input>

                    <x-wire-input label="Correlativo" wire:model="correlative" placeholder="Correlativo del Comprobante">
                    </x-wire-input>
                </div>

                <x-wire-input label="Fecha" wire:model="date" type="date">
                </x-wire-input>
                
                <x-wire-select label="Orden de Compra" wire:model.live="purchase_order_id" placeholder="Seleccione una orden de compra" :async-data="[
                    'api'=> route('api.purchase-orders.index'), 
                    'method'=> 'POST',]"
                    option-value="id"
                    option-label="name"
                    option-description="description">
                </x-wire-native-select>

                <div class="col-span-2">
                    <x-wire-select label="Proveedor" wire:model="supplier_id" placeholder="Seleccione un proveedor" :async-data="[
                        'api'=> route('api.suppliers.index'), 
                        'method'=> 'POST',]"
                        option-label="name"
                        option-value="id">
                    </x-wire-native-select>
                </div>

                <div class="col-span-2">
                    <x-wire-select label="Almacenes" wire:model.live="warehouse_id" placeholder="Seleccione un almacén" :async-data="[
                        'api'=> route('api.warehouses.index'), 
                        'method'=> 'POST',]"
                        option-value="id"
                        option-label="name"
                        option-description="description"
                        :disabled="count($products)"
                        >
                    </x-wire-native-select>
                </div>
            </div>
            
            <div class="lg:flex lg:space-x-4">
                <x-wire-select label="Producto" wire:model="product_id" placeholder="Seleccione un Producto" :async-data="[
                    'api'=> route('api.products.index'), 
                    'method'=> 'POST',]"
                    option-label="name"
                    option-value="id"
                    class="flex-1" />

                <div class="flex-shrink-0">
                    <x-wire-button wire:click="addProduct" spinner="addProduct" class="mt-6.5" >
                        Agregar Producto
                    </x-wire-button>
                </div>
            </div>
            
            <div class="overflow-x-auto w-full">
                <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-700 border-y bg-blue-50">
                        <th class="py-2 px-4">Producto</th>
                        <th class="py-2 px-4">Cantidad</th>
                        <th class="py-2 px-4">Precio</th>
                        <th class="py-2 px-4">Subtotal</th>
                        <th class="py-2 px-4"></th>
                    </tr>
                </thead>
                <tbody>

                    <template x-for="(product, index) in products" :key="product.id">
                        <tr class="border-b">
                            <td class="px-4 py-1" x-text="product.name"></td>
                            <td class="px-4 py-1">
                                <x-wire-input type="number" class="w-20" x-model="product.quantity">
                                </x-wire-input>
                            </td>
                            <td class="px-4 py-1">
                                <x-wire-input type="number" class="w-20" x-model="product.price" step="0.01">
                                </x-wire-input>
                            </td>
                            <td class="px-4 py-1" x-text="(product.quantity*product.price).toFixed(2)"></td>
                            <td class="px-4 py-1">
                                <x-wire-mini-button rounded x-on:click="removeProduct(index)" icon="trash" red >
                                {{-- <x-wire-mini-button rounded wire:click="removeProduct(index)" icon="trash" red > --}}
                                </x-wire-mini-button>
                            </td>
                        </tr>
                    </template>

                    <template x-if="products.length === 0">
                        <tr class="border-b">
                            <td colspan="5" class="text-center text-gray-500 py-4">
                                No hay producto agregados.
                            </td>
                        </tr>
                    </template>
                    

                    {{-- @forelse ($products as $index => $product)
                        <tr class="border-b">
                            <td class="px-4 py-1">{{$product['name']}}</td>
                            <td class="px-4 py-1">
                                <x-wire-input type="number" class="w-20" wire:model.live="products.{{$index}}.quantity">
                                </x-wire-input>
                            </td>
                            <td class="px-4 py-1">
                                <x-wire-input type="number" class="w-20" wire:model.live="products.{{$index}}.price" step="0.01">
                                </x-wire-input>
                            </td>
                            <td class="px-4 py-1">{{$product['quantity']*$product['price']}}</td>
                            <td class="px-4 py-1">
                                <x-wire-mini-button rounded icon="trash" red />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">
                                No hay producto agregados.
                            </td>
                        </tr>
                    @endforelse --}}
                        
                </tbody>
                </table>
            </div>

            <div class="flex items-center space-x-4">
                <x-label> {{-- componente de livewire --}}
                    Observaciones
                </x-label>
                
                <x-wire-input wire:model="observation" class="flex-1">
                </x-wire-input>

                <div>
                    total: S/. <span x-text="total.toFixed(2)"></span> 
                </div>

            </div>

            <div class="flex justify-end">
                <x-wire-button type="submit" icon="check" spinner="save">
                    Guardar
                </x-wire-button>
            </div>  

        </form>
    </x-wire-card>
</div>
