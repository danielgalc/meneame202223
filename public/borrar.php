<?php

session_start();

require '../vendor/autoload.php';

$id = obtener_get('id');


if (!isset($id)) {
    header('Location: /dashboard.php');
}

$pdo = $pdo ?? conectar();
$sent = $pdo->prepare("DELETE FROM noticias WHERE id = :id");
$sent->execute([':id' => $id]);

$_SESSION['exito'] = 'El artículo se ha borrado correctamente.';

header('Location: dashboard.php');
