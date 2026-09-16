# Sistema de Inventario

Proyecto académico de gestión de inventario con PHP POO y MySQL.

## Requisitos
- XAMPP (Apache + MySQL)
- PHP 8+
- Git

## Instalación
1. Copiar la carpeta `sistema-inventario` en `C:\xampp\htdocs\`.
2. Encender Apache y MySQL en XAMPP.
3. Crear la base de datos `inventario_db` en phpMyAdmin.
4. Abrir en el navegador: `http://localhost/sistema-inventario/public/`.

## Estructura
- `config/` → credenciales
- `core/` → clases base (Database, Model, autoload)
- `app/` → models, controllers, views
- `public/` → único punto de entrada
- `sql/` → scripts de base de datos