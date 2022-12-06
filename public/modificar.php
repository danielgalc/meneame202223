<?php

session_start();

require '../vendor/autoload.php';

$id = obtener_post('id');
$titular = obtener_post('titular');

$pdo = $pdo ?? conectar();
$sent = $pdo->prepare("UPDATE noticias SET titular = :titular WHERE id = :id");
$sent->execute([':titular' => $titular, 'id'=> $id]);

header('Location: /dashboard.php');