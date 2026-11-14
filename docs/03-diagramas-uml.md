# Diagramas UML — BibTum

Este documento reúne los diagramas UML del sistema. El diagrama de casos de uso está en [su propio documento](02-casos-de-uso.md).

1. [Diagrama de clases](#1-diagrama-de-clases)
2. [Diagramas de secuencia](#2-diagramas-de-secuencia)
3. [Diagrama de actividades](#3-diagrama-de-actividades)
4. [Diagrama de estados](#4-diagrama-de-estados)
5. [Diagrama de componentes](#5-diagrama-de-componentes)
6. [Diagrama de despliegue](#6-diagrama-de-despliegue)

## 1. Diagrama de clases

El código de BibTum es en su mayoría procedural: la única clase programada es `Utils`. Las clases `Autor`, `Libro` y `Categoria` representan el **modelo del dominio**; en el código corresponden a las tablas de la base de datos y a los arreglos que devuelven las consultas.

```mermaid
classDiagram
    class Categoria {
        +int id
        +string name
        +bool state
    }
    class Autor {
        +int id
        +string first_name
        +string last_name
        +date born_date
        +string pic_url
    }
    class Libro {
        +int id
        +string name_book
        +string description
        +date date_lan
        +string editorial
        +string rese
        +string img_book
    }
    class Utils {
        +getCRUDOptions(module, id, options) void
    }
    class FuncionesComunes {
        <<utility>>
        +e(value) string
        +imageUrl(url) string
    }
    class FormularioAutor {
        <<utility>>
        +authorFromPost() array
        +bindAuthor(stmt, data) void
    }

    Autor "1" --> "0..*" Libro : escribe
    Categoria "1" --> "0..*" Libro : clasifica
    FormularioAutor ..> Autor : valida
    Utils ..> FuncionesComunes : usa
```

| Elemento | Ubicación en el código |
|---|---|
| `Categoria`, `Autor`, `Libro` | Tablas `category`, `author` y `book` |
| `Utils` | `commons/Utils.php` |
| `FuncionesComunes` | Funciones `e()` e `imageUrl()` de `commons/Utils.php` |
| `FormularioAutor` | Funciones de `server/author/form.php` |

## 2. Diagramas de secuencia

### 2.1 Ver detalle de libro (CU02)

```mermaid
sequenceDiagram
    actor V as Visitante
    participant P as pages/book/detail.php
    participant S as server/book/detail.php
    participant D as PostgreSQL

    V->>P: GET detail.php?id=1
    P->>P: Valida que id sea un entero
    P->>S: include (id_b)
    S->>D: SELECT libro + autor + categoría
    D-->>S: Fila o vacío
    S-->>P: b
    alt El libro existe
        P-->>V: 200 Tarjeta con los datos
    else No existe o id inválido
        P-->>V: 404 "El libro no existe"
    end
```

### 2.2 Registrar autor (CU06)

```mermaid
sequenceDiagram
    actor A as Administrador
    participant P as pages/author/create.php
    participant S as server/author/create.php
    participant F as server/author/form.php
    participant D as PostgreSQL

    A->>P: GET create.php
    P-->>A: Formulario vacío
    A->>P: POST create.php (datos)
    P->>S: include
    S->>F: authorFromPost()
    F-->>S: data, errors
    alt Datos válidos
        S->>D: INSERT INTO author
        D-->>S: OK
        S-->>A: 302 Redirección al listado
        A->>P: GET pages/author/
    else Datos inválidos
        S-->>P: data, errors
        P-->>A: Formulario con errores
    end
```

### 2.3 Eliminar autor (CU08)

```mermaid
sequenceDiagram
    actor A as Administrador
    participant P as pages/author/delete.php
    participant S as server/author/delete.php
    participant D as PostgreSQL

    A->>P: GET delete.php?id=6
    P->>S: include (id_a)
    S->>D: SELECT autor y sus libros
    D-->>S: a, books
    alt El autor tiene libros
        P-->>A: Aviso: no se puede eliminar
    else Sin libros
        P-->>A: Pantalla de confirmación
        A->>P: POST delete.php?id=6
        P->>S: include (id_a)
        S->>D: DELETE FROM author
        D-->>S: OK
        S-->>A: 302 Redirección al listado
    end
```

## 3. Diagrama de actividades

Flujo de registrar o editar un autor.

```mermaid
flowchart TD
    I([Inicio]) --> F[Mostrar formulario]
    F --> E[El usuario completa los campos]
    E --> G{"¿Pulsa Guardar?"}
    G -- "No, Cancelar" --> L[Volver al listado]
    G -- Sí --> V{"¿Nombre y apellido válidos?"}
    V -- No --> ER[Mostrar errores y conservar lo escrito]
    ER --> E
    V -- Sí --> FE{"¿Fecha vacía o válida?"}
    FE -- No --> ER
    FE -- Sí --> U{"¿URL vacía o con http/https?"}
    U -- No --> ER
    U -- Sí --> SV[Guardar en la base de datos]
    SV --> R{"¿Es un registro nuevo?"}
    R -- Sí --> L
    R -- No --> DT[Mostrar detalle del autor]
    L --> FIN([Fin])
    DT --> FIN
```

## 4. Diagrama de estados

### 4.1 Categoría

El campo `state` decide si una categoría aparece en el menú. El cambio de estado se hace hoy directamente en la base de datos.

```mermaid
stateDiagram-v2
    [*] --> Activa : se crea
    Activa --> Inactiva : state = false
    Inactiva --> Activa : state = true
    Activa : Visible en el menú Categorías
    Inactiva : Oculta, su colección responde 404
```

### 4.2 Autor

```mermaid
stateDiagram-v2
    [*] --> SinLibros : se registra
    SinLibros --> ConLibros : se le asocia un libro
    ConLibros --> SinLibros : se quita su último libro
    SinLibros --> [*] : se elimina
    SinLibros : Sin libros (se puede eliminar)
    ConLibros : Con libros (no se puede eliminar)
```

## 5. Diagrama de componentes

```mermaid
flowchart LR
    subgraph NAV["Navegador"]
        html["Página HTML"]
        bs["Bootstrap 5.3.3<br/>CSS y JS"]
    end
    subgraph APP["Aplicación BibTum"]
        vistas["Vistas<br/>pages/ e index.php"]
        menu["Menú<br/>commons/menu.php"]
        logica["Lógica y consultas<br/>server/"]
        util["Utilidades<br/>commons/Utils.php"]
        con["Conexión<br/>commons/db.php"]
        cfg["Configuración<br/>commons/config.php"]
    end
    bd[("Base de datos<br/>bittum")]

    html --> vistas
    html --> bs
    vistas --> menu
    vistas --> logica
    vistas --> util
    menu --> con
    logica --> con
    con --> cfg
    con --> bd
```

## 6. Diagrama de despliegue

```mermaid
flowchart TB
    subgraph EQ["Nodo: equipo Windows"]
        subgraph NV["Entorno: navegador web"]
            cli["BibTum en el navegador"]
        end
        subgraph WP["Entorno: WAMP"]
            ap["Apache 2.4.65"]
            php["PHP 8.3.28 + pdo_pgsql"]
            art["Artefacto: carpeta Biblioteca"]
        end
        subgraph PG["Entorno: PostgreSQL 18"]
            bd[("Base bittum")]
        end
    end
    gh["GitHub<br/>repositorio Biblioteca"]

    cli -- "HTTP, puerto 80" --> ap
    ap --> php
    php --> art
    php -- "TCP, puerto 5432" --> bd
    art -. "git push / pull" .- gh
```
