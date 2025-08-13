<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Usuarios registrados</h1>
        <table class="w-full table-auto border-collapse mb-8">
            <thead>
                <tr class="text-left font-bold border-b-2">
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Correo</th>
                    <th class="px-4 py-2">Compras</th>
                    <th class="px-4 py-2">Total gastado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->orders->count() }}</td>
                        <td class="px-4 py-2">${{ $user->orders->sum('total') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-2">Ganancias totales</h2>
            <p class="text-green-600 font-bold">${{ $totalGanancias }}</p>
            <h2 class="text-xl font-bold mb-2 mt-4">Pérdidas totales</h2>
            <p class="text-red-600 font-bold">${{ $totalPerdidas }}</p>
        </div>
    </div>
</x-app-layout>
