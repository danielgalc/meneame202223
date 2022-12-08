<?php

use App\Tablas\Noticia;

 session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <title>Portal</title>
</head>

<body>
    <?php
    require '../vendor/autoload.php';

    $favorito = unserialize(favorito());

    $pdo = conectar();
    $sent = $pdo->query("SELECT * FROM usuarios u JOIN noticias n ON n.noticia_usuario = u.id ORDER BY likes DESC");
    ?>
    <div class="container mx-auto">
        <?php require '../src/_menu.php' ?>
        <div class="flex">
            <main class="flex-1 grid grid-cols-3 gap-4 justify-center justify-items-center">
                <?php foreach ($sent as $fila) : ?>
                    <div class="p-6 max-w-xs min-w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= hh($fila['titular']) ?></h5>
                        <a href="incrLikes.php?id=<?= $fila['id']?>&likes=<?= $fila['likes']?>">
                            <button class="inline-flex items-center px-2 py-1.5 text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">
                                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path d="M9.39 265.4l127.1-128C143.6 131.1 151.8 128 160 128s16.38 3.125 22.63 9.375l127.1 128c9.156 9.156 11.9 22.91 6.943 34.88S300.9 320 287.1 320H32.01c-12.94 0-24.62-7.781-29.58-19.75S.2333 274.5 9.39 265.4z" />
                                </svg>
                                <span class="sr-only">Arrow key up</span>
                            </button>
                        </a>
                        <a href="decrLikes.php?id=<?= $fila['id']?>&likes=<?= $fila['likes']?>">
                            <button class="mb-2 inline-flex items-center px-2 py-1.5 text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">
                                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path d="M310.6 246.6l-127.1 128C176.4 380.9 168.2 384 160 384s-16.38-3.125-22.63-9.375l-127.1-128C.2244 237.5-2.516 223.7 2.438 211.8S19.07 192 32 192h255.1c12.94 0 24.62 7.781 29.58 19.75S319.8 237.5 310.6 246.6z" />
                                </svg>
                                <span class="sr-only">Arrow key down</span>
                            </button>
                        </a>
                        
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= hh($fila['usuario']) ?></p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= hh($fila['likes']) ?> ♡</p>
                        <a href="/insertar_en_favoritos.php?id=<?= $fila['id'] ?>" class="w-32 inline-flex justify-center py-2 px-3.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Leer más
                            <svg aria-hidden="true" class="ml-3 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                <?php endforeach ?>
            </main>

            <?php if (!$favorito->vacio()) : ?>
                <aside class="flex flex-col items-center w-1/4" aria-label="Sidebar">
                    <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
                        <table class="mx-auto text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th scope="col" class="py-3 px-6">Titular</th>
                                <th scope="col" class="py-3 px-6">Likes</th>
                                <th scope="col" class="py-3 px-6">Usuario</th>
                            </thead>
                            <tbody>
                                <?php foreach ($favorito->getLineas() as $id => $linea): ?>
                                    <?php
                                    $noticia = $linea->getNoticia();
                                    $likes = $linea->getLikes();
                                    $noticia_usuario = $linea->getNoticiaUsuario();
                                    ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6"><?= $noticia->getTitular() ?></td>
                                        <td class="py-4 px-6 text-center"><?= $noticia->getLikes() ?></td>
                                        <td class="py-4 px-6 text-center"><?= $noticia->getNoticiaUsuario() ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <a href="/vaciar_favs.php" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Vaciar favoritos</a>
                    </div>
                </aside>
            <?php endif ?>
        </div>
    </div>
    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>

</html>