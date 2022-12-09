<?php 
session_start();

require '../vendor/autoload.php';

$usuario = obtener_post('usuario');
$titular = obtener_post('titular');


/* Validación de la longitud */

if (strlen($titular) < 4){
    $_SESSION['error'] = 'La longitud del titular es demasiado corta.';
    redirigir_dashboard();
} else if(strlen($titular) > 50){
    $_SESSION['error'] = 'La longitud del titular es demasiado larga.';
    redirigir_dashboard();
} else {    
    $pdo = conectar();
    $sent = $pdo->prepare('INSERT INTO noticias (titular, likes, noticia_usuario) VALUES (:titular, 0, :usuario)');
    $sent->execute(['usuario' => $usuario, ':titular' => $titular]);
    
    return redirigir_dashboard();
}