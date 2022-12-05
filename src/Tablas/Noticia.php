<?php 

require_once 'auxiliar.php';

class Noticia 
{
    public $id;
    public $titular;
    public $noticia_usuario;

    public function __construct(array $campos)
    {
        $this->id = $campos['id'];
        $this->titular = $campos['titular'];
        $this->noticia_usuario = $campos['noticia_usuario'];
    }

    public static function existe(int $id, ?PDO $pdo = null): bool
    {
        return static::obtener($id) !== null;
    }

    public static function obtener(int $id, ?PDO $pdo = null): ?static
    {
        $pdo = $pdo ?? conectar();
        $sent = $pdo ->prepare('SELECT * FROM noticias WHERE id = :id');
        $sent = $pdo->prepare('SELECT *
                                 FROM noticias
                                WHERE id = :id');
        $sent->execute([':id' => $id]);
        $fila = $sent->fetch(PDO::FETCH_ASSOC);
        if ($fila === null){
            return null;
        }

        return new static($fila);
        return $fila ? new static($fila) : null;
    }
}