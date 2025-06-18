<x-app-layout>
    <div class="px-4 py-40">
        <div class="flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-center mt-4">Pago Exitoso</h1>

        <p class="text-center mt-2">Gracias, {{ ucfirst($customer->name) }}.</p>
        <p class="text-center mt-2">Tu pago ha sido procesado exitosamente.</p>
        <div class="mt-6 flex justify-center">
            <a href="{{ route('home') }}" class="btn btn-default">Volver a la tienda</a>
        </div>
    </div>
</x-app-layout>
