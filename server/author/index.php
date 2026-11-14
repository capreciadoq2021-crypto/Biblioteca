<?php
// Deja $l con el listado de autores.
include_once __DIR__ . '/../../commons/db.php';

$s = $db->prepare('SELECT * FROM public.author ORDER BY id');
$s->execute();
$l = $s->fetchAll();
