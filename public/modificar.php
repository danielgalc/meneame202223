<?php

session_start();

require '../vendor/autoload.php';

$id = obtener_post('id');
$titular = obtener_post('titular');

$pdo = $pdo ?? conectar();
$sent = $pdo->prepare("UPDATE noticias SET titular = :titular WHERE id = :id");
$sent->execute([':id' => $id, ':titular' => $titular]);

redirigir_dashboard();