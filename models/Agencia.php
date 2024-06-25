<?php

class Agencia
{
    private $conexao;
    private $table_name = "agencia";

    public $id;
    public $nome;
    public $codigo;
    public $cidade_id;

    public function __construct($db)
    {
        $this->conexao = $db;
    }

    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NOME = :nome, CODIGO = :codigo, IDCIDADE = :cidade_id";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->codigo = htmlspecialchars(strip_tags($this->codigo));
        $this->cidade_id = htmlspecialchars(strip_tags($this->cidade_id));

        $conexao->bindParam(":nome", $this->nome);
        $conexao->bindParam(":codigo", $this->codigo);
        $conexao->bindParam(":cidade_id", $this->cidade_id);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function ler()
    {
        $query = "SELECT a.IDAGENCIA, a.NOME, a.CODIGO, a.IDCIDADE, 
                         e.NOME AS NOME_ESTADO, 
                         c.NOME AS NOME_CIDADE,
                         (SELECT COUNT(DISTINCT cliente_id) 
                          FROM contas 
                          WHERE agencia_id = a.IDAGENCIA) AS CLIENTES 
                  FROM " . $this->table_name . " a
                  JOIN cidade c ON a.IDCIDADE = c.IDCIDADE
                  JOIN estado e ON c.IDESTADO = e.IDESTADO";
        $conexao = $this->conexao->prepare($query);
        $conexao->execute();
        return $conexao;
    }

    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET NOME = :nome, CODIGO = :codigo, IDCIDADE = :cidade_id 
                  WHERE IDAGENCIA = :id";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->codigo = htmlspecialchars(strip_tags($this->codigo));
        $this->cidade_id = htmlspecialchars(strip_tags($this->cidade_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $conexao->bindParam(":nome", $this->nome);
        $conexao->bindParam(":codigo", $this->codigo);
        $conexao->bindParam(":cidade_id", $this->cidade_id);
        $conexao->bindParam(":id", $this->id);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function deletar()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE IDAGENCIA = :id";
        $conexao = $this->conexao->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $conexao->bindParam(":id", $this->id);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }
}
?>
