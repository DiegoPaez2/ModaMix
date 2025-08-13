
<x-app-layout>
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Historial de Facturas</h2>
        @if($orders->isEmpty())
            <p>No tienes facturas generadas aún.</p>
        @else
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border"># Pedido</th>
                    <th class="py-2 px-4 border">Fecha</th>
                    <th class="py-2 px-4 border">Total</th>
                    <th class="py-2 px-4 border">Factura</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="py-2 px-4 border">{{ $order->tracking_number }}</td>
                    <td class="py-2 px-4 border">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-2 px-4 border">${{ number_format($order->subtotal, 2) }}</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('factura.ver', $order->tracking_number) }}" target="_blank" class="text-blue-600 underline">Ver factura</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</x-app-layout>
