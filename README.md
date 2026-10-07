# Sistema de Inventario

Sistema de gestión de inventario con PHP, MySQL y patrón MVC. Incluye control de productos, categorías, movimientos de stock, alertas, punto de venta y exportación de reportes.

## Requisitos

- XAMPP (Apache + MySQL)
- PHP 8.0 o superior
- Git

## Instalación

1. Clonar el repositorio dentro de `C:\xampp\htdocs\`:

   ```
   git clone https://github.com/KalebCxDev/sistema-inventario.git
   ```

2. Encender Apache y MySQL desde el panel de XAMPP.

3. Crear la base de datos `inventario_db` e importar los archivos de la carpeta `sql/` desde phpMyAdmin.

4. Copiar `config.example.php` a `config.php` y ajustar las credenciales si es necesario.

5. Instalar las dependencias de Composer:

   ```
   cd sistema-inventario
   composer install
   ```

6. Abrir en el navegador:

   ```
   http://localhost/sistema-inventario/public/login.php
   ```

## Credenciales de prueba

| Usuario | Contraseña | Rol |
|---|---|---|
| admin | admin123 | admin |
| vendedor | vende123 | vendedor |
| recepcionista | recepc123 | recepcionista |

Las cuentas se crean ejecutando una vez el script `public/seed_usuarios.php`.

## Funcionalidades

- Login de usuarios con contraseñas hasheadas.
- Roles de usuario (admin, vendedor, recepcionista).
- CRUD de productos con validaciones.
- CRUD de categorías.
- Tipos de producto con herencia (estándar, perecedero).
- Registro de movimientos de entrada y salida con actualización automática de stock.
- Alertas de stock crítico con umbral distinto para perecederos.
- Punto de venta (POS) con carrito en el navegador.
- Historial de ventas.
- Exportación de productos a PDF y Excel.
- Buscador en vivo en el listado de productos.

## Estructura del proyecto

```
sistema-inventario/
├── config.php              → credenciales de la base de datos
├── conexion.php            → conexión PDO y carga de clases
├── auth.php                → manejo de sesiones y roles
├── modelos/                → clases de datos (Producto, Categoria, Movimiento, Venta, Usuario)
├── controladores/          → lógica de coordinación
├── vistas/                 → plantillas HTML
├── public/                 → punto de entrada y recursos del navegador
├── librerias/              → librerías externas (DOMPDF)
├── vendor/                 → dependencias instaladas por Composer
└── sql/                    → script de la base de datos
```

## Conceptos aplicados

- **MVC**: separación en modelos, controladores y vistas.
- **Encapsulamiento**: propiedades privadas con setters validados.
- **Herencia**: `ProductoPerecedero` extiende `Producto`.
- **Polimorfismo**: `stockCritico()` y `descripcion()` con comportamiento distinto según el tipo.
- **Sesiones**: manejo de login y roles.
- **Transacciones**: en el cobro del POS para garantizar consistencia.

## Autor

[KalebcxDev]