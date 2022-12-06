<?php 

require '../vendor/autoload.php';

$usuario = obtener_post('usuario');
$titular = obtener_post('titular');

$pdo = conectar();
$sent = $pdo->prepare('INSERT INTO noticias (titular, likes, noticia_usuario) VALUES (:titular, 0, :usuario)');
$sent->execute(['usuario' => $usuario, ':titular' => $titular]);

return volver();