<?php

session_start();

require '../vendor/autoload.php';
require '../src/_alerts.php';
require '../src/_menu.php';

$id = obtener_get('id');


if (!isset($id)) {
    header('Location: /dashboard.php');
}

$pdo = $pdo ?? conectar();
$sent = $pdo->prepare("UPDATE noticias SET titular = :titular WHERE id = :id");
$sent->execute([':titular' => $titular, 'id'=> $id]);
?>