<?php

class TipoConta
{
    private $conexao;
    private $table_name = "tipo_conta";

    public $id;
    public $nome;

    public function __construct($db)
    {
        $this->conexao = $db;
    }

    public function ler()
    {
        $query = "SELECT tc.*, 
                         (SELECT COUNT(*) FROM contas c WHERE c.tipo = tc.nome) as total_contas
                  FROM " . $this->table_name . " tc";
        $conexao = $this->conexao->prepare($query);
        $conexao->execute();
        return $conexao;
    }

    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $conexao->bindParam(":nome", $this->nome);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome WHERE id = :id";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $conexao->bindParam(':nome', $this->nome);
        $conexao->bindParam(':id', $this->id);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function deletar()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
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
