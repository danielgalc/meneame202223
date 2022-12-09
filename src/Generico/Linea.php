<?php

namespace App\Generico;

use App\Tablas\Noticia;

class Linea extends Modelo
{
    public Noticia $noticia;
    private int $likes;
    private $noticia_usuario;
    public $created_at;

    public function __construct(Noticia $noticia, int $likes = 1, $noticia_usuario = 1, $created_at=1)
    {
        $this->setNoticia($noticia);
        $this->setLikes($likes);
        $this->setNoticiaUsuario($noticia_usuario);
        $this->setFecha($created_at);
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

    public function setNoticiaUsuario($noticia_usuario)
    {
        $this->noticia_usuario = $noticia_usuario;
    }
    
    public function getNoticiaUsuario(): int
    {
        return $this->noticia_usuario;
    }

    public function getFecha()
    {
        return $this->created_at;
    }

    public function setFecha($created_at)
    {
        return $this->created_at = $created_at;
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