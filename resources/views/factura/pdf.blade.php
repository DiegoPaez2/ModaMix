
<x-app-layout>
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-full shadow transition">&larr; Regresar</a>
    </div>
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-lg p-8 mt-8 border border-indigo-200">
        <div class="flex items-center justify-between mb-8">
            <div>
                <img src="{{ asset('assets/imgs/logo/logo.png') }}" alt="ModaMix" class="h-16 mb-2">
                <div class="text-xl font-bold text-orange-600">MODAMIX S.A.</div>
                <div class="text-sm text-gray-600">RUC: 1234567890001</div>
                <div class="text-sm text-gray-600">Av. Principal 123, Quito, Ecuador</div>
                <div class="text-sm text-gray-600">Tel: (02) 123-4567 | contacto@modamix.com</div>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-bold text-indigo-700 mb-2">Factura Electrónica</h2>
                <div class="text-md font-semibold">N° Seguimiento: <span class="text-orange-600">{{ $order->tracking_number }}</span></div>
                <div class="text-md">Fecha: {{ $order->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
    <div class="mb-8 grid grid-cols-2 gap-4">
        <div>
            <div class="font-semibold text-indigo-700 mb-1">Cliente:</div>
            <div>{{ $order->user->name }}</div>
            <div>{{ $order->user->email }}</div>
        </div>
        <div>
            <div class="font-semibold text-indigo-700 mb-1">Dirección:</div>
            <div>{{ $order->billingDetail->billing_address ?? '' }}</div>
        </div>
    </div>
    <h4 class="text-xl font-bold text-indigo-700 mb-4">Detalle de productos</h4>
    <table class="min-w-full bg-white border rounded-xl mb-6">
        <thead class="bg-indigo-100">
            <tr>
                <th class="py-2 px-4 border">Producto</th>
                <th class="py-2 px-4 border">Cantidad</th>
                <th class="py-2 px-4 border">Precio unitario</th>
                <th class="py-2 px-4 border">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td class="py-2 px-4 border">{{ $item->product->name }}</td>
                <td class="py-2 px-4 border">{{ $item->qty }}</td>
                <td class="py-2 px-4 border">${{ number_format($item->price, 2) }}</td>
                <td class="py-2 px-4 border">${{ number_format($item->price * $item->qty, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex flex-col items-end">
        <div class="text-lg font-semibold">Subtotal: <span class="text-indigo-700">${{ number_format($order->subtotal, 2) }}</span></div>
        <div class="text-lg font-semibold">IVA (15%): <span class="text-indigo-700">${{ number_format($order->subtotal * 0.15, 2) }}</span></div>
        <div class="text-xl font-bold text-orange-600">Total a pagar: ${{ number_format($order->subtotal * 1.15, 2) }}</div>
    </div>
</div>


</x-app-layout>
