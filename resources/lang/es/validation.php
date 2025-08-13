<?php
return [
    'required' => 'El campo :attribute es obligatorio.',
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
    ],
    'digits' => 'El campo :attribute debe tener exactamente :digits dígitos.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'regex' => [
        'phone' => 'El teléfono debe tener el formato +593 y 9 dígitos.',
        'billing_address' => 'La dirección solo puede contener letras, números y espacios.',
        'city' => 'La ciudad solo puede contener letras y espacios.',
        'state' => 'El estado/cantón solo puede contener letras y espacios.',
    ],
    'in' => 'El campo :attribute debe ser Ecuador.',
    'attributes' => [
        'phone' => 'teléfono',
        'billing_address' => 'dirección',
        'city' => 'ciudad',
        'state' => 'estado/cantón',
        'zipcode' => 'código postal',
        'cedula' => 'cédula',
        'country' => 'país',
    ],
];
