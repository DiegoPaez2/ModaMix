            <h2 class="text-xl font-bold mb-2 mt-4">Pérdidas (productos sin ventas)</h2>
            <p class="text-red-600 font-bold">{{ $this->getPerdidas() }} productos sin ventas</p>
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2">Productos más vendidos</h2>
            <ul>
                @foreach($this->getTopProducts() as $prod)
                    <li>{{ $prod->name }} - Vendidos: {{ $prod->order_items_count }}</li>
                @endforeach
            </ul>
            <h2 class="text-xl font-bold mb-2 mt-4">Ganancias totales</h2>
            <p class="text-green-600 font-bold">${{ $this->getGanancias() }}</p>
        </div>
        <div class="mb-6">
            <button class="bg-orange-500 text-white px-4 py-2 rounded" wire:click="openModal()">Agregar producto</button>
        </div>
        @if($modalOpen)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
                    <h2 class="text-xl font-bold mb-4">{{ $editProductId ? 'Editar producto' : 'Agregar producto' }}</h2>
                    <form wire:submit.prevent="saveProduct">
                        <div class="mb-2">
                            <label>Nombre:</label>
                            <input type="text" wire:model="form.name" class="border rounded px-3 py-2 w-full" required>
                        </div>
                        <div class="mb-2">
                            <label>Precio:</label>
                            <input type="number" wire:model="form.price" class="border rounded px-3 py-2 w-full" required>
                        </div>
                        <div class="mb-2">
                            <label>Precio anterior:</label>
                            <input type="number" wire:model="form.old_price" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="mb-2">
                            <label>Cantidad:</label>
                            <input type="number" wire:model="form.quantity" class="border rounded px-3 py-2 w-full" required>
                        </div>
                        <div class="mb-2">
                            <label>Estado de stock:</label>
                            <select wire:model="form.stock_status" class="border rounded px-3 py-2 w-full">
                                <option value="instock">Disponible</option>
                                <option value="outstock">No disponible</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Categoría:</label>
                            <select wire:model="form.category_id" class="border rounded px-3 py-2 w-full">
                                <option value="">-- Selecciona --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Descripción corta:</label>
                            <input type="text" wire:model="form.brief_description" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="mb-2">
                            <label>Descripción:</label>
                            <textarea wire:model="form.description" class="border rounded px-3 py-2 w-full"></textarea>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
                            <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded" wire:click="closeModal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Inventario de productos</h1>
        <div class="mb-6 flex flex-wrap gap-4 items-center">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Buscar por nombre..." class="border rounded px-3 py-2" />
            <select wire:model="filterStock" class="border rounded px-3 py-2">
                <option value="">-- Estado de stock --</option>
                <option value="instock">Disponible</option>
                <option value="outstock">No disponible</option>
            </select>
            <select wire:model="filterCategory" class="border rounded px-3 py-2">
                <option value="">-- Categoría --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="text-left font-bold border-b-2">
                    <th class="px-4 py-2">Imagen</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Categoría</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Disponibilidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 rounded" alt="{{ $product->name }}">
                        </td>
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">
                            <button class="bg-blue-500 text-white px-2 py-1 rounded" wire:click="openModal({{ $product->id }})">Editar</button>
                            <button class="bg-red-500 text-white px-2 py-1 rounded" wire:click="deleteProduct({{ $product->id }})">Eliminar</button>
                        </td>
                        <td class="px-4 py-2">
                            @foreach ($product->categories as $cat)
                                <span class="bg-gray-200 rounded px-2 py-1 mr-1">{{ $cat->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">${{ $product->price }}</td>
                        <td class="px-4 py-2">{{ $product->quantity }}</td>
                        <td class="px-4 py-2">
                            @if ($product->stock_status === 'instock')
                                <span class="text-green-600 font-bold">Disponible</span>
                            @else
                                <span class="text-red-600 font-bold">No disponible</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
