<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderShipmentController extends Controller
{
    // Solo admins pueden actualizar el estado de envío
    public function update(Request $request, $orderId)
    {
        $request->validate([
            'shipping_status' => 'required|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
            'estimated_delivery' => 'nullable|date',
        ], [
            'shipping_status.required' => 'El estado de envío es obligatorio.',
            'shipping_status.string' => 'El estado de envío debe ser texto.',
            'tracking_number.string' => 'El número de seguimiento debe ser texto.',
            'estimated_delivery.date' => 'La fecha estimada debe ser válida.',
        ]);

        $order = Order::findOrFail($orderId);

        // Solo admins pueden actualizar
        if (!Auth::user() || !Auth::user()->is_admin) {
            abort(403, 'No autorizado');
        }

        $order->shipping_status = $request->shipping_status;
        $order->tracking_number = $request->tracking_number;
        $order->estimated_delivery = $request->estimated_delivery;
        $order->save();

        return redirect()->back()->with('success', 'Estado de envío actualizado correctamente.');
    }
}
