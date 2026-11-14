# Diccionario de datos — BibTum

| | |
|---|---|
| **Motor** | PostgreSQL 18 |
| **Base de datos** | `bittum` |
| **Esquema** | `public` |
| **Codificación** | UTF-8 |
| **Script** | [`database/bittum.sql`](../database/bittum.sql) |

Convenciones: **PK** clave primaria, **FK** clave foránea, **UK** valor único. En la columna "Nulo", **No** significa que el dato es obligatorio.

## 1. Resumen de tablas

| Tabla | Descripción | Registros de ejemplo |
|---|---|---|
| `category` | Categorías temáticas de los libros | 5 |
| `author` | Autores | 5 |
| `book` | Libros del catálogo | 6 |

## 2. Tabla `category`

Categorías en las que se clasifican los libros. Las categorías activas forman el menú "Categorías".

| Columna | Tipo | Longitud | Nulo | Clave | Valor por defecto | Descripción | Ejemplo |
|---|---|---|---|---|---|---|---|
| `id` | `serial` (entero) | — | No | PK | Autoincremental | Identificador de la categoría | `1` |
| `name` | `varchar` | 60 | No | UK | — | Nombre de la categoría. Se guarda en minúsculas y se muestra con mayúscula inicial | `ficción` |
| `state` | `boolean` | — | No | — | `TRUE` | Indica si la categoría está activa (`TRUE`) u oculta (`FALSE`) | `TRUE` |

## 3. Tabla `author`

Autores de los libros.

| Columna | Tipo | Longitud | Nulo | Clave | Valor por defecto | Descripción | Ejemplo |
|---|---|---|---|---|---|---|---|
| `id` | `serial` (entero) | — | No | PK | Autoincremental | Identificador del autor | `1` |
| `first_name` | `varchar` | 80 | No | — | — | Nombre o nombres | `Gabriel` |
| `last_name` | `varchar` | 80 | No | — | — | Apellido o apellidos | `García Márquez` |
| `born_date` | `date` | — | Sí | — | `NULL` | Fecha de nacimiento | `1927-03-06` |
| `pic_url` | `text` | Sin límite | Sí | — | `NULL` | Dirección web de la foto. Debe empezar por `http://` o `https://`. Si está vacía se muestra la imagen por defecto | `https://ejemplo.com/foto.jpg` |

## 4. Tabla `book`

Libros del catálogo.

| Columna | Tipo | Longitud | Nulo | Clave | Valor por defecto | Descripción | Ejemplo |
|---|---|---|---|---|---|---|---|
| `id` | `serial` (entero) | — | No | PK | Autoincremental | Identificador del libro | `1` |
| `name_book` | `varchar` | 200 | No | — | — | Título | `Cien años de soledad` |
| `author_id` | `integer` | — | No | FK → `author.id` | — | Autor del libro | `1` |
| `category_id` | `integer` | — | No | FK → `category.id` | — | Categoría del libro | `1` |
| `description` | `text` | Sin límite | Sí | — | `NULL` | Descripción o sinopsis | `La historia de la familia Buendía…` |
| `date_lan` | `date` | — | Sí | — | `NULL` | Fecha de lanzamiento | `1967-05-30` |
| `editorial` | `varchar` | 120 | Sí | — | `NULL` | Nombre de la editorial | `Sudamericana` |
| `rese` | `text` | Sin límite | Sí | — | `NULL` | Reseña | `Obra cumbre del realismo mágico.` |
| `img_book` | `text` | Sin límite | Sí | — | `NULL` | Dirección web de la portada. Si está vacía se muestra la imagen por defecto | `https://ejemplo.com/portada.jpg` |

## 5. Claves foráneas

| Tabla | Columna | Referencia | Al borrar el registro referenciado |
|---|---|---|---|
| `book` | `author_id` | `author(id)` | `RESTRICT`: se impide el borrado del autor |
| `book` | `category_id` | `category(id)` | `RESTRICT`: se impide el borrado de la categoría |

## 6. Índices

| Índice | Tabla | Columnas | Tipo | Origen |
|---|---|---|---|---|
| `category_pkey` | `category` | `id` | Único | Clave primaria |
| `category_name_key` | `category` | `name` | Único | Restricción `UNIQUE` |
| `author_pkey` | `author` | `id` | Único | Clave primaria |
| `book_pkey` | `book` | `id` | Único | Clave primaria |
| `book_author_idx` | `book` | `author_id` | No único | Acelera la búsqueda de libros por autor |
| `book_category_idx` | `book` | `category_id` | No único | Acelera la búsqueda de libros por categoría |

## 7. Secuencias

| Secuencia | Usada por |
|---|---|
| `category_id_seq` | `category.id` |
| `author_id_seq` | `author.id` |
| `book_id_seq` | `book.id` |

## 8. Campos calculados en las consultas

Estos datos no se almacenan; la aplicación los obtiene al consultar.

| Nombre | Expresión | Usado en |
|---|---|---|
| `author` | `author.first_name \|\| ' ' \|\| author.last_name` | Listado y detalle de libros, colecciones |
| `category` | `initcap(category.name)` | Detalle de libro |
| `name` | `initcap(category.name)` | Menú y título de la colección |

## 9. Validaciones de la aplicación

Reglas que se comprueban en el formulario de autor antes de guardar (`server/author/form.php`):

| Campo | Regla | Mensaje |
|---|---|---|
| `first_name` | Obligatorio, máximo 80 caracteres | "El nombre es obligatorio (máximo 80 caracteres)." |
| `last_name` | Obligatorio, máximo 80 caracteres | "El apellido es obligatorio (máximo 80 caracteres)." |
| `born_date` | Opcional; si se indica, fecha real en formato `AAAA-MM-DD` | "La fecha de nacimiento no es válida." |
| `pic_url` | Opcional; si se indica, empieza por `http://` o `https://` | "La URL de la foto debe empezar por http:// o https://." |
