<?php

class Cidade
{
    private $conexao;
    private $table_name = "cidade";

    public $id;
    public $nome;
    public $IDESTADO;

    public function __construct($db)
    {
        $this->conexao = $db;
    }

    public function ler()
    {
        $query = "SELECT c.*, e.NOME as ESTADO_NOME FROM " . $this->table_name . " c LEFT JOIN estado e ON c.IDESTADO = e.IDESTADO";
        $conexao = $this->conexao->prepare($query);
        $conexao->execute();
        return $conexao;
    }

    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " SET NOME=:nome, IDESTADO=:IDESTADO";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->IDESTADO = htmlspecialchars(strip_tags($this->IDESTADO));

        $conexao->bindParam(":nome", $this->nome);
        $conexao->bindParam(":IDESTADO", $this->IDESTADO);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " SET NOME = :nome, IDESTADO = :IDESTADO WHERE IDCIDADE = :id";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->IDESTADO = htmlspecialchars(strip_tags($this->IDESTADO));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $conexao->bindParam(':nome', $this->nome);
        $conexao->bindParam(':IDESTADO', $this->IDESTADO);
        $conexao->bindParam(':id', $this->id);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function deletar()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE IDCIDADE = :id";
        $conexao = $this->conexao->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $conexao->bindParam(':id', $this->id);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }
}
?>
