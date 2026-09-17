# Sistema de Inventario

Proyecto académico de gestión de inventario con PHP POO y MySQL.

## Requisitos
- XAMPP (Apache + MySQL)
- PHP 8+
- Git

## Instalación
1. Copiar la carpeta `sistema-inventario` en `C:\xampp\htdocs\`.
2. Encender Apache y MySQL en XAMPP.
3. Importar `sql/inventario.sql` desde phpMyAdmin.
4. Abrir en el navegador: `http://localhost/sistema-inventario/public/`.

## Funcionalidades
- CRUD de productos con validaciones.
- CRUD de categorías.
- Tipos de producto con herencia (estándar, frágil, perecedero).
- Comportamientos polimórficos por tipo.
- Registro de movimientos (entrada/salida) con actualización automática de stock.
- Alertas de stock crítico con umbral distinto para perecederos.
- Panel de inicio con contadores.

## Estructura
- `config/` → credenciales de base de datos.
- `core/` → clases base (Database, Model, autoload).
- `app/models/` → Producto, Categoria, Movimiento.
- `app/controllers/` → controladores.
- `app/views/` → vistas HTML.
- `public/` → único punto de entrada.
- `sql/` → script de base de datos.

## Conceptos POO aplicados
- Encapsulamiento: propiedades privadas con setters validados.
- Herencia: ProductoEstandar, ProductoFragil, ProductoPerecedero extienden Producto.
- Polimorfismo: descripcion(), detallesExtra() y stockCritico() con comportamiento distinto por tipo.