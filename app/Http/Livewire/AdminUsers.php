<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Order;
use Livewire\Component;

class AdminUsers extends Component
{
    public function render()
    {
        $users = User::with('orders')->get();
        $totalGanancias = Order::sum('total');
        $totalPerdidas = 0; // Aquí podrías calcular devoluciones o productos no vendidos si tienes esa lógica
        return view('livewire.admin-users', compact('users', 'totalGanancias', 'totalPerdidas'));
    }
}
