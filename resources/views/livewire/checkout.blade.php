<x-app-layout>
    <section class="mt-50 mb-50">
        <div class="alert alert-info mb-4 text-center text-indigo-700 bg-indigo-100 rounded">
            Por favor, llena los datos de facturación y selecciona el método de pago para completar tu pedido. Revisa el resumen a la derecha antes de finalizar.
        </div>
        <div class="container">
                <div class="mb-4">
                    <a href="{{ route('dashboard') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-full shadow transition">&larr; Regresar</a>
                </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-25">
                        <h4 class="font-semibold text-lg text-gray-600">Detalles de facturación</h4>
                    </div>
                    <form method="post" action="{{route('checkout.order')}}" id="checkoutForm">
                        @csrf
                        {{-- El número de seguimiento y el enlace de factura solo se muestran después de realizar el pedido --}}
                        <x-input-label for="state" :value="'Provincia/Estado'" />
                        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full border-2 border-indigo-300 rounded-lg focus:border-indigo-500" value="{{$billingDetails ? $billingDetails->state : ''}}" placeholder="Ejemplo: Pichincha" />
                        <x-input-error class="mt-2 text-red-600" :messages="$errors->get('state')" />
                        </div>
                        <x-input-label for="country" :value="'País'" />
                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" value="Ecuador" readonly />
                        <x-input-error class="mt-2 text-red-600" :messages="$errors->get('country')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="billing_address" :value="'Dirección *'" />
                            <x-text-input id="billing_address" name="billing_address" type="text"
                                class="mt-1 block w-full" value="{{$billingDetails ? $billingDetails->billing_address : ''}}" required autofocus autocomplete="billing_address" />
                            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('billing_address')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="city" :value="'Ciudad *'" />
                            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full border-2 border-indigo-300 rounded-lg focus:border-indigo-500"
                                autofocus autocomplete="city" value="{{$billingDetails ? $billingDetails->city : ''}}"/>
                            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('city')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="parroquia_barrio" :value="'Parroquia / Barrio *'" />
                            <x-text-input id="parroquia_barrio" name="parroquia_barrio" type="text" class="mt-1 block w-full border-2 border-indigo-300 rounded-lg focus:border-indigo-500"
                                autofocus autocomplete="parroquia_barrio" value="{{$billingDetails ? $billingDetails->parroquia_barrio : ''}}"/>
                            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('parroquia_barrio')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="zipcode" :value="'Código postal *'" />
                            <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full border-2 border-indigo-300 rounded-lg focus:border-indigo-500"
                                autofocus autocomplete="zipcode" value="{{$billingDetails ? $billingDetails->zipcode : ''}}"/>
                            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('zipcode')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="phone" :value="'Teléfono *'" />
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-indigo-300 bg-gray-100 text-gray-700 text-sm">+593</span>
                                <input id="phone" name="phone" type="text" maxlength="9" pattern="[0-9]{9}" class="mt-1 block w-full border-2 border-indigo-300 rounded-r-lg focus:border-indigo-500" autofocus autocomplete="phone" value="{{$billingDetails ? ltrim($billingDetails->phone, '+593') : ''}}" placeholder="Ingrese los 9 dígitos" required />
                            </div>
                            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('phone')" />
                        </div>
                        <div class="form-group mb-30">
                            <x-input-label for="order_notes" :value="'Información adicional'" />
                            <x-text-input id="order_notes" name="order_notes" type="text" class="mt-1 block w-full border-2 border-indigo-300 rounded-lg focus:border-indigo-500"
                                autofocus autocomplete="order_notes" placeholder="¿Alguna nota?" value="{{$billingDetails ? $billingDetails->order_notes : ''}}"/>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="payment_method" :value="'Forma de pago *'" />
                            <select id="payment_method" name="payment_method" class="mt-1 block w-full" required>
                                <option value="tarjeta">Tarjeta de crédito</option>
                                <option value="transferencia">Transferencia bancaria</option>
                                <option value="efectivo">Pago en efectivo</option>
                            </select>
                            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('payment_method')" />
                        </div>
                        <button type="submit" class="btn btn-block mt-30">Realizar pedido</button>
                    </form>
                <!-- Fin columna izquierda -->
                <div class="col-md-6">
                    <div class="order_review border-0">
                        <div class="mb-5">
                            <h3 class="my-2 text-lg font-semibold text-gray-600">Tus pedidos</h3>
                        </div>
                        <div class="table-responsive order_table text-center">
                            <div class="col-md-6">
                                <div class="order_review bg-white p-4 rounded shadow-lg">
                                    <h4 class="mb-3 font-bold text-xl text-indigo-700 text-center">Resumen de tu pedido</h4>
                                    <ul class="list-group mb-3">
                                        @foreach (Cart::content() as $item)
                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                <div>
                                                    <h6 class="my-0">{{ $item->name }}</h6>
                                                    <small class="text-muted">Cantidad: {{ $item->qty }}</small>
                                                </div>
                                                <span class="text-muted">${{ number_format($item->price * $item->qty, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Subtotal</span>
                                            <strong>${{ number_format(Cart::subtotal(), 2) }}</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>IVA (15%)</span>
                                            <strong>${{ number_format(Cart::subtotal() * 0.15, 2) }}</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Total</span>
                                            <strong>${{ number_format(Cart::subtotal() * 1.15, 2) }}</strong>
                                        </li>
                                    </ul>
                                    @if(session('tracking_number'))
                                        <div class="alert alert-info mt-3 text-center">
                                            <strong>Número de seguimiento:</strong> {{ session('tracking_number') }}
                                        </div>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success mt-3 text-center">
                                            Su pago se realizó con éxito.<br>
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </div>
                            </table>
                        </div>
                        {{-- <div class="bt-1 border-color-1 mt-30 mb-30"></div> --}}
                        {{-- <form class="">
                            <h3 class="my-2 text-lg font-semibold text-gray-600">How would you like to pay?</h3>
                            <ul class="grid w-full gap-6 md:grid-cols-2">
                                <li>
                                    <input type="radio" id="cod" name="payment" value="cod"
                                        class="hidden peer" required>
                                    <label for="cod"
                                        class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border border-gray-200 shadow-md rounded-lg cursor-pointer peer-checked:border-orange-500 peer-checked:text-orange-500 hover:text-gray-600 hover:bg-gray-100 ">
                                        <div class="block">
                                            <div class="w-full text-lg font-semibold">Cash on delivery</div>
                                        </div>
                                        <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="card" name="payment" value="card"
                                        class="hidden peer" required>
                                    <label for="card"
                                        class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border border-gray-200 shadow-md rounded-lg cursor-pointer peer-checked:border-orange-500 peer-checked:text-orange-500 hover:text-gray-600 hover:bg-gray-100 ">
                                        <div class="block">
                                            <div class="w-full text-lg font-semibold">Pay with card</div>
                                        </div>
                                        <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </label>
                                </li>
                            </ul>
                        </form> --}}
                        <div class="mb-4">
                            <x-input-label for="payment_method" :value="'Forma de pago *'" />
                            <select id="payment_method" name="payment_method" class="mt-1 block w-full" required>
                                <option value="tarjeta">Tarjeta de crédito</option>
                                <option value="transferencia">Transferencia bancaria</option>
                                <option value="efectivo">Pago en efectivo</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('payment_method')" />
                        </div>
                        <button type="submit" class="btn btn-block mt-30" onclick="document.getElementById('checkoutForm').submit();">Realizar pedido</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
