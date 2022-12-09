<?php

session_start();

require '../vendor/autoload.php';

$id = obtener_post('id');

if (!isset($id)) {
    header('Location: /dashboard.php');
}

$pdo = $pdo ?? conectar();
$sent = $pdo->prepare("DELETE FROM noticias WHERE id = :id");
$sent->execute([':id' => $id]);

$_SESSION['exito'] = 'El artículo se ha borrado correctamente.';

$usuario = unserialize($_SESSION['login']);

if ($usuario->es_admin()){
    volver_admin();
} else {
    redirigir_dashboard();
}
