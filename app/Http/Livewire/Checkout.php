<?php

namespace App\Http\Livewire;

use App\Mail\OrderReceived;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\InvoiceService;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart as CartFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// ...existing code...
class Checkout extends Component
{
    public function confirmation()
    {
        $trackingNumber = session('tracking_number') ?? session('tracking_number', request()->session()->get('tracking_number'));
        $success = session('success');
        return view('livewire.confirmation', compact('trackingNumber', 'success'));
    }

    public function stripeCheckout()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $lineItems = [];
    foreach (CartFacade::content() as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->model->name,
                    ],
                    'unit_amount' => $item->model->price * 100,
                ],
                'quantity' => $item->qty,
            ];
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success')."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel'),
        ]);

    $total = str_replace(',', '', CartFacade::total());
        $order = new Order([
            'user_id' => Auth::user()->id,
            'status' => 'pending',
            'total' => $total,
            'session_id' => $checkout_session->id,
        ]);
        $order->save();

    foreach (CartFacade::content() as $item) {
            $price = str_replace(',', '', $item->price);
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
                'price' => $price
            ]);
            $orderItem->save();
        }

        return $checkout_session->url;
    }

    public function success(Request $request, InvoiceService $invoiceService)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $sessionId = $request->get('session_id');

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if (!$session) {
                throw new NotFoundHttpException();
            }
            $order = Order::where('session_id', $session->id)->first();
            $customer = \Stripe\Customer::retrieve($session->customer);
            if ($order->status === 'pending') {
                $order->status = 'processing';
                $order->save();
            }
            Mail::to($order->user->email)->send(new OrderReceived($order, $invoiceService->createInvoice($order)));
            CartFacade::destroy();
            return view('livewire.success', compact('customer'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            throw new NotFoundHttpException();
        }
        return redirect()->route('home');
    }

    public function cancel()
    {
        return redirect()->route('home')->with('success', 'Your order has been canceled.');
    }

    public function makeOrder(Request $request)
    {
        $validatedRequest = $request->validate([
            'country' => ['string'],
            'city' => ['string'],
            'state' => ['string'],
            'zipcode' => ['string'],
            'phone' => ['required', 'string'],
            'billing_address' => ['required'],
            'payment_method' => ['required', 'string', 'in:tarjeta,transferencia,efectivo'],
        ]);
        if (!isset($data['state'])) {
            $data['state'] = $request->input('state', '');
        }
        if (!isset($data['zipcode'])) {
            $data['zipcode'] = $request->input('zipcode', '');
        }
        if (!isset($data['phone'])) {
            $data['phone'] = $request->input('phone', '');
        }

        $user = Auth::user();
        // Aseguramos que parroquia_barrio esté presente
        $data = $validatedRequest;
        if (!isset($data['parroquia_barrio'])) {
            $data['parroquia_barrio'] = $request->input('parroquia_barrio', '');
        }
        if (!isset($data['country'])) {
            $data['country'] = $request->input('country', 'Ecuador');
        }
        if (!isset($data['city'])) {
            $data['city'] = $request->input('city', '');
        }
        if ($user->billingDetails === null) {
            $user->billingDetails()->create($data);
        } else {
            $user->billingDetails()->update($data);
        }

        // Generar número de seguimiento aleatorio
        $tracking_number = 'EC-' . rand(100000, 999999);

        // Crear la orden y guardar el tracking_number
        $total = str_replace(',', '', CartFacade::total());
        $order = $user->orders()->create([
            'tracking_number' => $tracking_number,
            'status' => 'pending',
            'total' => $total,
        ]);
            $data = $validatedRequest;
            if (!isset($data['parroquia_barrio'])) {
                $data['parroquia_barrio'] = $request->input('parroquia_barrio', '');
            }
            if ($user->billingDetails === null) {
                $user->billingDetails()->create($data);
            } else {
                $user->billingDetails()->update($data);
            }

            // Generar número de seguimiento aleatorio
            $tracking_number = 'EC-' . rand(100000, 999999);

            // Crear la orden y guardar el tracking_number
            $order = $user->orders()->create([
                'tracking_number' => $tracking_number,
                'status' => 'pending',
                'total' => CartFacade::total(),
            ]);
            foreach (Cart::content() as $item) {
                $order->orderItems()->create([
                    'product_id' => $item->id,
                    'price' => $item->price,
                    'quantity' => $item->qty,
                ]);
            }
            Cart::destroy();

            // Mensaje de éxito y datos para la vista de confirmación
            return redirect()->route('checkout.confirmation')->with([
                'tracking_number' => $tracking_number,
                'success' => 'Pago realizado correctamente. Tu número de seguimiento es ' . $tracking_number . '. Puedes ver y descargar tu factura en el dashboard.' ,
                'order_id' => $order->id
            ]);
    }

    public function render()
    {
        if (CartFacade::count() <= 0) {
            session()->flash('error', 'Your cart is empty.');
            return redirect()->route('home');
        }
        $user = Auth::user();
        $billingDetails = $user->billingDetails;
        $trackingNumber = session('tracking_number');
        return view('livewire.checkout', compact('billingDetails', 'trackingNumber'));
    }
}
