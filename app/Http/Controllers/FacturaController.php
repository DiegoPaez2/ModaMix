<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
    /**
     * Muestra el historial de facturas del usuario autenticado.
     */
    public function historial()
    {
        $user = auth()->user();
        $orders = \App\Models\Order::where('user_id', $user->id)->orderByDesc('created_at')->get();
        return view('factura.historial', compact('orders'));
    }
    /**
     * Visualiza la factura en pantalla por número de seguimiento.
     */
    public function ver($tracking)
    {
        $order = \App\Models\Order::where('tracking_number', $tracking)->firstOrFail();
        $billing = $order->billingDetail;
        $productos = $order->orderItems;
        $pdfView = view('factura.pdf', compact('order', 'billing', 'productos'))->render();

        return response($pdfView);
    }

}
