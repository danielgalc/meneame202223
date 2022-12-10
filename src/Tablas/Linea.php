<?php

namespace App\Tablas;

use App\Tablas\Noticia;

class Linea extends Modelo
{
    private Noticia $articulo;
    private int $cantidad;

    public function __construct(array $campos)
    {
        $this->articulo = Noticia::obtener($campos['articulo_id']);
        $this->cantidad = $campos['cantidad'];
    }

    public function getArticulo(): Noticia
    {
        return $this->articulo;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }
}