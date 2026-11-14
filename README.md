# BibTum

Aplicación web de biblioteca en PHP con PostgreSQL y Bootstrap 5.

## Requisitos

- WAMP (Apache + PHP 8) con la extensión `pdo_pgsql` activada
- PostgreSQL

## Instalación

1. Coloca el proyecto en `C:\wamp64\www\Biblioteca`.
2. Crea la base de datos y carga el esquema con los datos de ejemplo:

   ```bash
   createdb -U postgres -E UTF8 bittum
   psql -U postgres -d bittum -f database/bittum.sql
   ```

3. Copia `commons/config.example.php` como `commons/config.php` y escribe tus credenciales.
4. Activa `pdo_pgsql` en WAMP (ícono de WAMP → PHP → Extensiones PHP → `pdo_pgsql`).
5. Abre <http://localhost/Biblioteca/>.

## Estructura

- `commons/`: conexión a la base, menú y utilidades.
- `pages/`: vistas (HTML + PHP).
- `server/`: consultas SQL que usa cada vista.
- `database/`: script SQL del esquema y los datos de ejemplo.

## Documentación

Los documentos de análisis y diseño (arquitectura, casos de uso, UML, modelo de datos, wireframes, guía UI/UX y navegación) están en [docs/](docs/README.md).
