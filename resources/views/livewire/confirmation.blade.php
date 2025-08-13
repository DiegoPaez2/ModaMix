
<x-app-layout>
    <div class="container mx-auto py-8">
        @if($success)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ $success }}
            </div>
        @endif
        @if($trackingNumber)
            <div class="mb-4">
                <span class="font-semibold">Número de seguimiento:</span> {{ $trackingNumber }}
            </div>
            <div>
                <a href="{{ route('factura.ver', $trackingNumber) }}" target="_blank" class="text-blue-600 underline">Ver factura generada</a>
            </div>
        @endif
        <div class="mt-8">
            <a href="{{ route('home') }}" class="btn btn-primary">Volver al inicio</a>
        </div>
    </div>
</x-app-layout>
