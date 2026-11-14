# Guía de diseño UI/UX — BibTum

Esta guía define cómo debe verse y comportarse la interfaz para que todas las pantallas, actuales y futuras, sean coherentes. BibTum usa **Bootstrap 5.3.3** sin estilos propios, así que la guía se apoya en sus componentes y valores por defecto.

## 1. Principios

1. **Claridad antes que decoración.** Cada pantalla tiene un solo propósito y un solo título.
2. **Consistencia.** La misma acción se ve y se llama igual en todas partes.
3. **Prevención de errores.** Las acciones destructivas piden confirmación; los formularios validan y conservan lo escrito.
4. **Retroalimentación.** Toda situación anómala (registro inexistente, datos inválidos, lista vacía) tiene un mensaje visible.
5. **Accesibilidad.** Idioma declarado, textos alternativos, etiquetas en los campos y contraste suficiente.

## 2. Colores

Se usan los colores de Bootstrap; no se definen colores propios.

| Uso | Nombre | Valor | Dónde |
|---|---|---|---|
| Acción principal y enlaces | `primary` | `#0d6efd` | Botones "Guardar", "Nuevo autor", "Ver libros"; enlaces e íconos |
| Acción secundaria | `secondary` | `#6c757d` | Botón "Cancelar" (contorno) |
| Acción destructiva | `danger` | `#dc3545` | Botón "Eliminar" y recuadro de errores |
| Aviso | `warning` | `#ffc107` | Mensajes "no existe" y "no se puede eliminar" |
| Texto | `body-color` | `#212529` | Texto general |
| Fondo | `body-bg` | `#ffffff` | Fondo de página |
| Fondo de la barra | `body-tertiary` | `#f8f9fa` | Barra de navegación |
| Imagen por defecto | — | `#e9ecef` con texto `#6c757d` | `img/placeholder.svg` |

Reglas:

- Solo **un botón principal** por pantalla.
- El rojo se reserva para eliminar y para errores.
- El color nunca es el único indicador: los avisos siempre llevan texto.

## 3. Tipografía

Fuente del sistema de Bootstrap (`system-ui`, Segoe UI en Windows, Roboto en Android, etc.). No se cargan fuentes externas.

| Elemento | Etiqueta | Tamaño |
|---|---|---|
| Título de página | `<h1>` | 2.5 rem |
| Título de tarjeta de libro | `<h2 class="card-title">` | 2 rem |
| Título de tarjeta de autor | `<h5 class="card-title">` | 1.25 rem |
| Frase de presentación | `<p class="lead">` | 1.25 rem |
| Texto general | `<p>`, `<td>`, `<li>` | 1 rem (16 px) |

Cada página tiene un único `<h1>`.

## 4. Estructura de página

```text
┌──────────────────────────────────────────────┐
│ Barra de navegación (commons/menu.php)       │
├──────────────────────────────────────────────┤
│                                              │
│      <h1> Título de la página                │
│                                              │
│      Contenido: tabla, tarjeta o formulario  │
│                                              │
└──────────────────────────────────────────────┘
```

- Contenedor: `container text-center`.
- Listados y detalles: columna central de 10/12 (`col-1`, `col-10`, `col-1`).
- Tarjetas: `card mx-auto`, ancho 18 rem.
- Formularios: ancho máximo 30 rem, centrados, con el texto alineado a la izquierda.

## 5. Componentes

| Componente | Clase de Bootstrap | Uso |
|---|---|---|
| Barra de navegación | `navbar navbar-expand-lg bg-body-tertiary` | En todas las páginas |
| Menú desplegable | `dropdown-menu` | Categorías y Administrador |
| Tabla | `table` | Listados |
| Tarjeta | `card`, `list-group list-group-flush` | Detalles |
| Botón principal | `btn btn-primary` | Guardar, Nuevo autor, Ver libros |
| Botón secundario | `btn btn-outline-secondary`, `btn btn-outline-primary` | Cancelar, Ver autores |
| Botón destructivo | `btn btn-danger` | Confirmar eliminación |
| Campo de formulario | `form-label` + `form-control` | Formulario de autor |
| Aviso | `alert alert-warning` | Registro inexistente, eliminación no permitida |
| Error | `alert alert-danger` | Errores de validación |
| Opción no disponible | `dropdown-item disabled` | Préstamos y Socios |

### 5.1 Íconos de acción

Los listados usan tres íconos de Bootstrap Icons, insertados como SVG de 16 × 16 px por `Utils::getCRUDOptions()`.

| Ícono | Acción | Texto accesible |
|---|---|---|
| Ojo (`bi-eye-fill`) | Ver detalle | "Ver" |
| Lápiz (`bi-pen-fill`) | Editar | "Editar" |
| Papelera (`bi-trash-fill`) | Eliminar | "Eliminar" |

- Siempre en ese orden.
- Solo se muestran las acciones que el módulo tiene implementadas (en libros, solo "Ver").
- Cada ícono lleva `title` y `aria-label`.

### 5.2 Imágenes

- Fotos de autor y portadas van en la parte superior de la tarjeta (`card-img-top`).
- Si no hay imagen se usa `img/placeholder.svg`.
- Texto alternativo: "Foto de {nombre}" o "Portada de {título}".

## 6. Formularios

- Cada campo tiene su `<label>` visible, encima del campo.
- Los campos opcionales lo indican en la etiqueta: "URL de la foto (opcional)".
- Se usa el tipo de campo adecuado: `date` para fechas, `url` para direcciones.
- Los campos obligatorios llevan `required` y el límite `maxlength`, y además **se validan siempre en el servidor**.
- Si hay errores, se listan todos juntos encima del formulario y los campos conservan lo que el usuario escribió.
- Orden de botones: primero la acción principal ("Guardar"), luego "Cancelar".

## 7. Mensajes y redacción

- Idioma: español, con tuteo y tono neutro.
- Títulos en formato de oración: "Listado de autores", no "Listado De Autores".
- Los botones nombran la acción con un verbo: "Guardar", "Eliminar", "Cancelar".
- Los mensajes dicen qué pasó y, si aplica, por qué.

| Situación | Mensaje |
|---|---|
| Libro inexistente | "El libro no existe." |
| Autor inexistente | "El autor no existe." |
| Categoría inexistente o inactiva | "La categoría no existe." |
| Categoría sin libros | "Todavía no hay libros en esta categoría." |
| Autor sin libros | "Sin libros registrados" |
| Confirmación de borrado | "¿Seguro que quieres eliminar a {nombre}? Esta acción no se puede deshacer." |
| Borrado no permitido | "No se puede eliminar a {nombre} porque tiene {n} libro(s) registrado(s)." |
| Fallo de conexión | "No se pudo conectar a la base de datos." |

Formato de datos:

- Fechas: `AAAA-MM-DD`, tal como las entrega la base de datos.
- Nombres de categoría: con mayúscula inicial.
- Nombre de autor: nombre seguido de apellido.

## 8. Patrones de interacción

| Patrón | Regla |
|---|---|
| Crear | Tras guardar se vuelve al listado, donde aparece el nuevo registro |
| Editar | Tras guardar se muestra el detalle del registro actualizado |
| Eliminar | Siempre pasa por una pantalla de confirmación; tras eliminar se vuelve al listado |
| Cancelar | Vuelve al listado sin cambios |
| Detalle | Incluye un enlace "Volver al listado" |
| Recarga | Tras guardar se redirige, de modo que recargar la página no repite la operación |
| Elemento inexistente | Aviso amarillo dentro de la página, con la barra de navegación disponible |

## 9. Accesibilidad

- Todas las páginas declaran `lang="es"` y `meta viewport`.
- Las imágenes tienen texto alternativo descriptivo.
- Los enlaces que solo contienen un ícono llevan `aria-label`.
- El botón del menú plegado lleva `aria-label="Abrir menú"`.
- Todos los campos están asociados a su etiqueta con `for` e `id`.
- La interfaz es operable con teclado: enlaces, botones y campos son elementos nativos.
- Los colores de texto de Bootstrap sobre fondo blanco cumplen el contraste mínimo de 4.5:1.

## 10. Diseño adaptable

| Ancho | Comportamiento |
|---|---|
| ≥ 992 px | Barra de navegación desplegada en una línea |
| < 992 px | Las opciones se pliegan tras el botón de menú |
| Cualquiera | Tablas al ancho de la columna central; tarjetas y formularios centrados |

## 11. Pendientes de diseño

- Las tablas no tienen desplazamiento horizontal en pantallas muy estrechas (falta `table-responsive`).
- La opción del menú correspondiente a la página actual no se resalta.
- No hay mensaje de confirmación ("Autor guardado") después de crear, editar o eliminar.
- No hay paginación en los listados.
