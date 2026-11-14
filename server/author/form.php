<?php
// Lee y valida los campos del formulario de autor.
// Devuelve [$data, $errors]; $errors queda vacío si todo es válido.
function authorFromPost()
{
    $data = [
        'first_name' => trim((string) ($_POST['first_name'] ?? '')),
        'last_name' => trim((string) ($_POST['last_name'] ?? '')),
        'born_date' => trim((string) ($_POST['born_date'] ?? '')),
        'pic_url' => trim((string) ($_POST['pic_url'] ?? '')),
    ];
    $errors = [];

    if ($data['first_name'] === '' || mb_strlen($data['first_name']) > 80) {
        $errors[] = 'El nombre es obligatorio (máximo 80 caracteres).';
    }
    if ($data['last_name'] === '' || mb_strlen($data['last_name']) > 80) {
        $errors[] = 'El apellido es obligatorio (máximo 80 caracteres).';
    }
    if ($data['born_date'] !== '') {
        $date = DateTime::createFromFormat('Y-m-d', $data['born_date']);
        if (!$date || $date->format('Y-m-d') !== $data['born_date']) {
            $errors[] = 'La fecha de nacimiento no es válida.';
        }
    }
    if ($data['pic_url'] !== '' && !preg_match('#^https?://#i', $data['pic_url'])) {
        $errors[] = 'La URL de la foto debe empezar por http:// o https://.';
    }

    return [$data, $errors];
}

// Asocia los campos del autor a una sentencia preparada (vacío => NULL).
function bindAuthor($stmt, $data)
{
    $stmt->bindValue(':fn', $data['first_name'], PDO::PARAM_STR);
    $stmt->bindValue(':ln', $data['last_name'], PDO::PARAM_STR);
    foreach ([':bd' => 'born_date', ':pu' => 'pic_url'] as $param => $field) {
        if ($data[$field] === '') {
            $stmt->bindValue($param, null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue($param, $data[$field], PDO::PARAM_STR);
        }
    }
}
