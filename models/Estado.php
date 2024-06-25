<?php

class Estado
{
    private $conexao;
    private $table_name = "estado";

    public $id;
    public $nome;
    public $sigla;

    public function __construct($db)
    {
        $this->conexao = $db;
    }

    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $conexao = $this->conexao->prepare($query);
        $conexao->execute();
        return $conexao;
    }

    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " SET NOME=:nome, SIGLA=:sigla";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->sigla = htmlspecialchars(strip_tags($this->sigla));

        $conexao->bindParam(":nome", $this->nome);
        $conexao->bindParam(":sigla", $this->sigla);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " SET NOME = :nome, SIGLA = :sigla WHERE IDESTADO = :id";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->sigla = htmlspecialchars(strip_tags($this->sigla));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $conexao->bindParam(':nome', $this->nome);
        $conexao->bindParam(':sigla', $this->sigla);
        $conexao->bindParam(':id', $this->id);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function deletar()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE IDESTADO = :id";
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
