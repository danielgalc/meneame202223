<?php

session_start();

require '../src/auxiliar.php';

$id = obtener_get('id');
$likes = obtener_get('likes');

$likes--;

$pdo = $pdo ?? conectar();
$sent = $pdo->prepare("UPDATE noticias SET likes = :likes WHERE id = :id");
$sent->execute([':id' => $id, ':likes' => $likes]);
return volver();
