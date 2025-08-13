<x-app-layout>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Mis pedidos</h1>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="text-left font-bold border-b-2">
                    <th class="px-4 py-2">Imagen</th>
                    <div class="mb-4">
                        <a href="/" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-full shadow transition">&larr; Regresar al inicio</a>
                    </div>
                    <th class="px-4 py-2">Producto</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Fecha</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2 flex items-center">
                            @php
                                $quantity = 0;
                            @endphp
                            @foreach ($order->orderItems as $item)
                            @php
                                $quantity += $item->quantity
                            @endphp
                                <a href="{{ route('product.details', $item->product->id) }}"><img
                                        src="{{ asset('storage/'.$item->product->image) }}" class="w-20 h-20 mr-4 rounded"></a>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">
                           <ul >
                            @foreach ($order->orderItems as $item)
                                <li>
                                    <a href="{{ route('product.details', $item->product->id) }}">
                                      -  {{ $item->product->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        </td>
                        <td class="px-4 py-2">
                            {{ $order->status }}<br>
                            Estado de envío: {{ $order->shipping_status ?? 'Pendiente' }}<br>
                            <div class="mb-2">
                                <span class="font-bold text-indigo-600">N° seguimiento:</span>
                                <span id="tracking-{{ $order->id }}" class="bg-indigo-100 px-2 py-1 rounded text-indigo-800 font-mono">{{ $order->tracking_number ?? 'No asignado' }}</span>
                                @if($order->tracking_number)
                                    <button onclick="navigator.clipboard.writeText('{{ $order->tracking_number }}')" class="ml-2 px-2 py-1 bg-indigo-500 text-white rounded text-xs">Copiar</button>
                                @endif
                            </div>
                            @if($order->shipping_status == 'en camino')
                                <div class="alert alert-info p-2 rounded text-blue-700 bg-blue-100 mb-2">¡Tu pedido está en camino!</div>
                            @elseif($order->shipping_status == 'entregado')
                                <div class="alert alert-success p-2 rounded text-green-700 bg-green-100 mb-2">¡Tu pedido ha sido entregado!</div>
                            @endif
                            Fecha estimada: {{ $order->estimated_delivery ?? 'No asignada' }}
                            @if(auth()->user()->is_admin)
                                <form method="post" action="{{ route('admin.order.shipment.update', $order->id) }}" class="mt-2">
                                    @csrf
                                    <select name="shipping_status" class="border rounded px-2 py-1">
                                        <option value="pendiente" {{ $order->shipping_status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="en camino" {{ $order->shipping_status == 'en camino' ? 'selected' : '' }}>En camino</option>
                                        <option value="entregado" {{ $order->shipping_status == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                    </select>
                                    <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="N° seguimiento" class="border rounded px-2 py-1" />
                                    <input type="date" name="estimated_delivery" value="{{ $order->estimated_delivery }}" class="border rounded px-2 py-1" />
                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Actualizar</button>
                                </form>
                            @endif
                        </td>
                        <td class="px-4 py-2">${{ $order->total }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('F j, Y') }}</td>
                        <td class="px-4 py-2">{{ $quantity }}</td>
                        <td class="px-4 py-2">
                            <a href="{{route('invoice', $order)}}" class="bg-orange-500 text-white px-4 py-2 font-semibold rounded-full" target="_blank">
                                Ver factura</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
</x-app-layout>
