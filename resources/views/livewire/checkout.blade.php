<x-app-layout>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-25">
                        <h4 class="font-semibold text-lg text-gray-600">Detalles de Facturación</h4>
                    </div>
                    <form method="post" action="{{route('checkout.order')}}" id="checkoutForm">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="country" :value="__('País *')" />
                            @include('livewire.countries-select')
                            <x-input-error class="mt-2" :messages="$errors->get('country')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="billing_address" :value="__('Dirección *')" />
                            <x-text-input id="billing_address" name="billing_address" type="text"
                                class="mt-1 block w-full" value="{{$billingDetails ? $billingDetails->billing_address : ''}}" required autofocus autocomplete="billing_address" />
                            <x-input-error class="mt-2" :messages="$errors->get('billing_address')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="city" :value="__('Ciudad *')" />
                            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="city" value="{{$billingDetails ? $billingDetails->city : ''}}"/>
                            <x-input-error class="mt-2" :messages="$errors->get('city')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="state" :value="__('Estado / Provincia *')" />
                            <x-text-input id="state" name="state" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="state" value="{{$billingDetails ? $billingDetails->state : ''}}"/>
                            <x-input-error class="mt-2" :messages="$errors->get('state')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="zipcode" :value="__('Código Postal / ZIP *')" />
                            <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="zipcode" value="{{$billingDetails ? $billingDetails->zipcode : ''}}"/>
                            <x-input-error class="mt-2" :messages="$errors->get('zipcode')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="phone" :value="__('Número de teléfono *')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="phone" value="{{$billingDetails ? $billingDetails->phone : ''}}"/>
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>
                        <div class="form-group mb-30">
                            <x-input-label for="order_notes" :value="__('Información adicional')" />
                            <x-text-input id="order_notes" name="order_notes" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="order_notes" placeholder="¿Alguna nota?" value="{{$billingDetails ? $billingDetails->order_notes : ''}}"/>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="order_review border-0">
                        <div class="mb-5">
                            <h3 class="my-2 text-lg font-semibold text-gray-600">Tus pedidos</h3>
                        </div>
                        <div class="table-responsive order_table text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Producto</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $i)
                                        <tr>
                                            <td class="image product-thumbnail"><img src="{{ asset('storage/'.$i->model->image) }}"
                                                    alt="#">
                                            </td>
                                            <td>
                                                <h5><a
                                                        href="{{ route('product.details', $i->model->id) }}">{{ $i->model->name }}</a>
                                                </h5>
                                                <span class="product-qty">x {{ $i->qty }}</span>
                                            </td>
                                            <td>${{ $i->subtotal }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Subtotal</th>
                                        <td class="product-subtotal" colspan="2">${{ Cart::subtotal() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Impuesto</th>
                                        <td class="product-subtotal" colspan="2">${{ Cart::tax() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Envío</th>
                                        <td colspan="2"><em>Envío Gratis</em></td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td colspan="2" class="product-subtotal"><span
                                                class="font-xl text-brand fw-900">${{ Cart::total() }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="bt-1 border-color-1 mt-30 mb-30"></div> --}}
                        {{-- <form class="">
                            <h3 class="my-2 text-lg font-semibold text-gray-600">¿Cómo te gustaría pagar?</h3>
                            <ul class="grid w-full gap-6 md:grid-cols-2">
                                <li>
                                    <input type="radio" id="cod" name="payment" value="cod"
                                        class="hidden peer" required>
                                    <label for="cod"
                                        class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border border-gray-200 shadow-md rounded-lg cursor-pointer peer-checked:border-orange-500 peer-checked:text-orange-500 hover:text-gray-600 hover:bg-gray-100 ">
                                        <div class="block">
                                            <div class="w-full text-lg font-semibold">Pago contra entrega</div>
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
                                            <div class="w-full text-lg font-semibold">Pagar con tarjeta</div>
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
                        <button type="submit" class="btn btn-block mt-30" onclick="document.getElementById('checkoutForm').submit();">Realizar pedido</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
