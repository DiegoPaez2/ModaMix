<x-mail::message>
# Tu pedido ha sido completado

Tu pedido #{{ $order->id }} ha sido enviado.

¡Gracias por tu compra!

<a href="{{ url('/dashboard') }}" style="background-color: #ed8936; color: #ffffff; font-weight: bold; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">Ver tu pedido</a>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
