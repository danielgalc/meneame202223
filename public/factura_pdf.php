<?php

session_start();

use App\Tablas\Factura;
use Carbon\Carbon;

require '../vendor/autoload.php';

if (!($usuario = \App\Tablas\Usuario::logueado())) {
    return volver();
}

$id = obtener_get('id');

if (!isset($id)) {
    return volver();
}

$pdo = conectar();

$factura = Factura::obtener($id, $pdo);

if (!isset($factura)) {
    return volver();
}

if ($factura->getUsuarioId() != $usuario->id) {
    return volver();
}

$filas_tabla = '';
$total = 0;

foreach ($factura->getLineas($pdo) as $linea) {
    $titular = $linea->getNoticia();
    Carbon::parse($titular->getFecha())->toFormattedDateString();
    

    $filas_tabla .= <<<EOF
        <tr>
            <td>$titular</td>
            <td>$fecha</td>
        </tr>
    EOF;
}

$res = <<<EOT
<p>Factura número: {$factura->id}</p>
<table border="1" class="font-sans mx-auto">
    <tr>
        <th>Código</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Importe</th>
    </tr>
    <tbody>
        $filas_tabla
    </tbody>
</table>
<p>Total: $total</p>
EOT;

// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();

// Write some HTML code:
$mpdf->WriteHTML(file_get_contents('css/output.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($res, \Mpdf\HTMLParserMode::HTML_BODY);

// Output a PDF file directly to the browser
$mpdf->Output();