<?php

namespace App\Generico;

use App\Tablas\Noticia;

class Linea extends Modelo
{
    public Noticia $noticia;
    private int $likes;

    public function __construct(Noticia $noticia, int $likes = 1)
    {
        $this->setNoticia($noticia);
        $this->setLikes($likes);
    }

    public function getNoticia(): Noticia
    {
        return $this->noticia;
    }

    public function setNoticia(Noticia $noticia)
    {
        $this->noticia = $noticia;
    }

    
    public function setLikes(int $likes)
    {
        $this->likes = $likes;
    }
    
    public function getLikes(): int
    {
        return $this->likes;
    }
/*     public function incrCantidad()
    {
        $this->cantidad++;
    }

    public function decrCantidad()
    {
        $this->cantidad--;
    } */
}