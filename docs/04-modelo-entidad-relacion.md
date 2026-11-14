# Modelo entidad-relación (MER) — BibTum

Base de datos: `bittum` (PostgreSQL), esquema `public`. El script que la crea está en [`database/bittum.sql`](../database/bittum.sql).

## 1. Diagrama

```mermaid
erDiagram
    CATEGORY ||--o{ BOOK : "clasifica"
    AUTHOR ||--o{ BOOK : "escribe"

    CATEGORY {
        serial id PK
        varchar name UK "Nombre de la categoría"
        boolean state "Activa o inactiva"
    }
    AUTHOR {
        serial id PK
        varchar first_name "Nombre"
        varchar last_name "Apellido"
        date born_date "Fecha de nacimiento"
        text pic_url "URL de la foto"
    }
    BOOK {
        serial id PK
        varchar name_book "Título"
        integer author_id FK "Autor"
        integer category_id FK "Categoría"
        text description "Descripción"
        date date_lan "Fecha de lanzamiento"
        varchar editorial "Editorial"
        text rese "Reseña"
        text img_book "URL de la portada"
    }
```

## 2. Entidades

| Entidad | Tabla | Descripción | Clave primaria |
|---|---|---|---|
| Categoría | `category` | Clasificación temática de los libros (ficción, ciencia, historia…) | `id` |
| Autor | `author` | Persona que escribió uno o más libros | `id` |
| Libro | `book` | Obra del catálogo de la biblioteca | `id` |

## 3. Relaciones

| Relación | Entidades | Cardinalidad | Lectura | Implementación |
|---|---|---|---|---|
| escribe | Autor — Libro | 1 : N | Un autor escribe cero o muchos libros; cada libro tiene exactamente un autor | `book.author_id` → `author.id` |
| clasifica | Categoría — Libro | 1 : N | Una categoría agrupa cero o muchos libros; cada libro pertenece a exactamente una categoría | `book.category_id` → `category.id` |

En ambas relaciones la participación del libro es **obligatoria** (las claves foráneas son `NOT NULL`) y la del autor y la categoría es **opcional** (pueden existir sin libros).

## 4. Reglas de integridad

| Regla | Cómo se garantiza |
|---|---|
| Cada registro se identifica de forma única | Clave primaria `id` autoincremental en las tres tablas |
| No hay dos categorías con el mismo nombre | Restricción `UNIQUE` sobre `category.name` |
| Un libro siempre tiene autor y categoría existentes | Claves foráneas `NOT NULL` |
| No se puede borrar un autor que tiene libros | `ON DELETE RESTRICT` en `book.author_id`, y la aplicación lo comprueba antes de borrar |
| No se puede borrar una categoría que tiene libros | `ON DELETE RESTRICT` en `book.category_id` |
| Nombre y apellido del autor son obligatorios | `NOT NULL` y validación en el formulario |
| Una categoría nueva queda activa | `state` tiene valor por defecto `TRUE` |

## 5. Normalización

El modelo está en **tercera forma normal**:

- **1FN**: todos los atributos son atómicos y no hay grupos repetidos.
- **2FN**: todas las claves primarias son de un solo atributo, por lo que no hay dependencias parciales.
- **3FN**: ningún atributo depende de otro que no sea la clave. El nombre del autor y el de la categoría no se guardan en `book`; se obtienen con `JOIN` a partir de `author_id` y `category_id`.

## 6. Limitaciones y evolución del modelo

- Un libro admite **un solo autor**. Para libros con varios autores haría falta una tabla intermedia `book_author` (relación N : M).
- La **editorial** es un texto libre en `book`. Si se necesitara gestionarlas, pasaría a ser una entidad propia.
- Los módulos de **socios** y **préstamos** que aparecen en el menú no tienen tablas todavía. Un diseño posible sería:

```mermaid
erDiagram
    MEMBER ||--o{ LOAN : "solicita"
    BOOK ||--o{ LOAN : "se presta en"
    MEMBER {
        serial id PK
        varchar full_name
        varchar email UK
        boolean state
    }
    LOAN {
        serial id PK
        integer member_id FK
        integer book_id FK
        date loan_date
        date due_date
        date return_date
    }
    BOOK {
        serial id PK
    }
```

> Este segundo diagrama es una **propuesta**; esas tablas no existen en la base actual.
