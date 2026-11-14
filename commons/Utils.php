<?php
// Escapa un valor para imprimirlo dentro de HTML.
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// Devuelve la URL de la imagen o la imagen por defecto si no hay ninguna.
function imageUrl($url)
{
    return ($url === null || $url === '') ? '/Biblioteca/img/placeholder.svg' : $url;
}

class Utils
{
    // Imprime los íconos de ver / editar / eliminar para un registro.
    // $options permite limitar las acciones a las que el módulo tiene implementadas.
    function getCRUDOptions($module, $id, $options = ['detail', 'edit', 'delete'])
    {
        $icons = [
            'detail' => ['Ver', 'bi-eye-fill',
                '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>' .
                '<path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>'],
            'edit' => ['Editar', 'bi-pen-fill',
                '<path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>'],
            'delete' => ['Eliminar', 'bi-trash-fill',
                '<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>'],
        ];

        $links = [];
        foreach ($options as $option) {
            if (!isset($icons[$option])) {
                continue;
            }
            [$label, $class, $path] = $icons[$option];
            $links[] =
                '<a href="' . e($module . $option . '.php?id=' . urlencode((string) $id)) . '"' .
                ' title="' . $label . '" aria-label="' . $label . '">' .
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"' .
                ' class="bi ' . $class . '" viewBox="0 0 16 16">' . $path . '</svg>' .
                '</a>';
        }
        echo implode('&nbsp;&nbsp;&nbsp;', $links);
    }
}
