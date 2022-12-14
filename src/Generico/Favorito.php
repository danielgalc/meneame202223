<?php

namespace App\Generico;

use App\Tablas\Noticia;
use ValueError;

class Favorito extends Modelo
{
    private array $lineas;

    public function __construct()
    {
        $this->lineas = [];
    }

    public function insertar($id)
    {
        if (!($noticia = Noticia::obtener($id))) {
            throw new ValueError('El artículo no existe.');
        }

         if (!isset($this->lineas[$id])) {
             $this->lineas[$id] = new Linea($noticia);
             $_SESSION['exito']='Noticia añadida a favoritos correctamente.';
        } else {
            $_SESSION['error']='Esta noticia ya está en favoritos.';
        }
    }

/*     public function eliminar($id)
    {
        if (isset($this->lineas[$id])) {
            $this->lineas[$id]->decrCantidad();
            if ($this->lineas[$id]->getCantidad() == 0) {
                unset($this->lineas[$id]);
            }
        } else {
            throw new ValueError('Artículo inexistente en el carrito');
        }
    } */

    public function vacio(): bool
    {
        return empty($this->lineas);
    }

    public function getLineas(): array
    {
        return $this->lineas;
    }
}