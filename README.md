

# ModaMix

ModaMix es una tienda virtual de moda desarrollada en Laravel, donde los usuarios pueden explorar un catálogo de productos, gestionar su carrito de compras y realizar pedidos con facturación electrónica. El sistema incluye registro y autenticación, panel de administración, y permite a los clientes visualizar sus facturas y el estado de sus órdenes. El proyecto está enfocado en ofrecer una experiencia de compra sencilla, segura y moderna.


## ✨ Características

- 🔐 Registro y autenticación de usuarios
- 🛍️ Catálogo de productos
- 🛒 Carrito de compras
- 💳 Checkout con validaciones
- 📦 Gestión de órdenes y facturas
- 🛠️ Panel de administración

- 🔙 Botón de regresar en todas las vistas principales
- 📄 Visualización de factura (sin descarga)
- 🧹 El carrito se vacía automáticamente tras la compra
- 💰 Factura muestra el valor pagado correctamente

---

## 🚀 Instalación rápida

<ol>
	<li>Clona el repositorio y entra a la carpeta:<br>
	<pre>git clone &lt;URL-del-repositorio&gt;
cd ModaMix</pre></li>
	<li>Instala dependencias:<br>
	<pre>composer install
npm install</pre></li>
	<li>Configura <code>.env</code> y genera la clave:<br>
	<pre>cp .env.example .env
    php artisan key:generate</pre></li>
	<li>Migra la base de datos:<br>
	<pre>php artisan migrate --seed</pre></li>
	<li>Compila los assets:<br>
	<pre>npm run dev</pre></li>
	<li>Inicia el servidor:<br>
	<pre>php artisan serve</pre></li>
</ol>

---

## 📝 Ejemplo de uso

1. Ingresa a <code>http://localhost:8000</code>
2. Navega por el catálogo, agrega productos al carrito y realiza el checkout.
3. Tras la compra, el carrito se vacía automáticamente.
4. Puedes ver tus facturas desde el dashboard, solo visualización (no descarga).
5. En todas las vistas principales hay un botón para regresar fácilmente.
2. Regístrate con tus datos
3. Explora productos y agrégalos al carrito
4. Finaliza tu compra en el checkout
5. Consulta tus órdenes y descarga facturas

---

## 🏗️ Arquitectura del Proyecto

El proyecto sigue una arquitectura MVC (Modelo-Vista-Controlador) usando Laravel y Livewire:

- **Modelo:** Eloquent ORM para la gestión de datos y relaciones.
- **Vista:** Blade y Livewire para interfaces reactivas y componentes dinámicos.
- **Controlador:** Controladores y componentes Livewire para la lógica de negocio y flujo de datos.

**Estructura principal:**

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Livewire/
│   ├── Models/
│   └── ...
├── resources/
│   ├── views/
│   └── ...
├── public/
├── routes/
├── config/
├── database/
└── ...
```

---

## 🧰 Tecnologías Usadas

- **Backend:** Laravel 10, PHP 8+
- **Frontend:** Blade, Livewire, TailwindCSS, Vite
- **Base de datos:** MySQL
- **Gestión de dependencias:** Composer, npm
- **Carrito:** Gloudemans Shoppingcart
- **Facturación:** LaravelDaily Invoices
- **Autenticación:** Laravel Breeze
- **Testing:** PHPUnit

---

## 📸 Ejemplo visual

<p align="center">
	<img src="https://img.icons8.com/color/96/000000/online-store.png" alt="Ejemplo visual" width="80"/>
</p>

---



