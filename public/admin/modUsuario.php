<?php

session_start();

require '../../vendor/autoload.php';

$id = obtener_get('id');
$usuario = obtener_get('usuario');


$pdo = $pdo ?? conectar();
$sent = $pdo->prepare("UPDATE usuarios SET usuario = :usuario WHERE id = :id");
$sent->execute([':id' => $id, ':usuario' => $usuario]);



$usuario = unserialize($_SESSION['login']);

if ($usuario->es_admin()){
    volver_admin();
} else {
    redirigir_dashboard();
}