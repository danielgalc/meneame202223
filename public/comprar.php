<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <title>Comprar</title>
</head>

<body>
    <?php require '../vendor/autoload.php';

    use Carbon\Carbon;

    if (!\App\Tablas\Usuario::esta_logueado()) {
        return redirigir_login();
    }

    $favorito = unserialize(favorito());

    if (obtener_post('_testigo') !== null) {
        // Crear factura
        $pdo = conectar();
        $usuario = \App\Tablas\Usuario::logueado();
        $usuario_id = $usuario->id;
        $pdo->beginTransaction();
        $sent = $pdo->prepare('INSERT INTO facturas (usuario_id)
                               VALUES (:usuario_id)
                               RETURNING id');
        $sent->execute([':usuario_id' => $usuario_id]);
        $factura_id = $sent->fetchColumn();
        $lineas = $favorito->getLineas();
        $values = [];
        $execute = [':f' => $factura_id];
        $i = 1;

        foreach ($lineas as $id => $linea) {
            $values[] = "(:a$i, :f, :c$i)";
            $execute[":a$i"] = $id;
            $execute[":c$i"] = $linea->getLikes();
            $i++;
        }

        $values = implode(', ', $values);
        $sent = $pdo->prepare("INSERT INTO noticias_facturas (noticia_id, factura_id, cantidad)
                               VALUES $values");
        $sent->execute($execute);
        $pdo->commit();
        $_SESSION['exito'] = 'La factura se ha creado correctamente.';
        unset($_SESSION['favorito']);
        return volver();
    }

    ?>

    <div class="container mx-auto">
        <?php require '../src/_menu.php' ?>
        <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
            <table class="mx-auto text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <th scope="col" class="py-3 px-6">Titular</th>
                    <th scope="col" class="py-3 px-6">Fecha</th>
                </thead>
                <tbody>
                    <?php $total = 0 ?>
                    <?php foreach ($favorito->getLineas() as $id => $linea) : ?>
                        <?php
                        $titular = $linea->getNoticia();
                        ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6"><?= $titular->getTitular() ?></td>
                            <td class="py-4 px-6"><?= Carbon::parse($titular->getFecha())->toFormattedDateString()?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <form action="" method="POST" class="mx-auto flex mt-4">
                <input type="hidden" name="_testigo" value="1">
                <button type="submit" href="/factura_pdf.php" class="mx-auto focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">Realizar pedido</button>
            </form>
        </div>
    </div>
    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>

</html>