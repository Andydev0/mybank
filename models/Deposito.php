<?php

class Deposito
{
    private $conexao;
    private $table_name = "depositos";

    public $id;
    public $cliente_id;
    public $conta_id;
    public $valor;
    public $data_hora;

    public function __construct($db)
    {
        $this->conexao = $db;
    }

    public function ler()
    {
        $query = "SELECT d.*, cl.NOME as CLIENTE_NOME, ag.CODIGO as AGENCIA_CODIGO, c.numero_conta, tc.nome as tipo_conta
                  FROM " . $this->table_name . " d
                  LEFT JOIN cliente cl ON d.cliente_id = cl.IDCLIENTE
                  LEFT JOIN contas c ON d.conta_id = c.id
                  LEFT JOIN agencia ag ON c.agencia_id = ag.IDAGENCIA
                  LEFT JOIN tipo_conta tc ON c.tipo = tc.id
                  ORDER BY d.data_hora DESC";
        $conexao = $this->conexao->prepare($query);
        $conexao->execute();
        return $conexao;
    }

    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET cliente_id = :cliente_id, conta_id = :conta_id, valor = :valor, data_hora = :data_hora";
        $conexao = $this->conexao->prepare($query);

        $this->cliente_id = htmlspecialchars(strip_tags($this->cliente_id));
        $this->conta_id = htmlspecialchars(strip_tags($this->conta_id));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->data_hora = htmlspecialchars(strip_tags($this->data_hora));

        $conexao->bindParam(":cliente_id", $this->cliente_id);
        $conexao->bindParam(":conta_id", $this->conta_id);
        $conexao->bindParam(":valor", $this->valor);
        $conexao->bindParam(":data_hora", $this->data_hora);

        if ($conexao->execute()) {
            // Atualizar saldo da conta
            $update_query = "UPDATE contas SET saldo = saldo + :valor WHERE id = :conta_id";
            $update_conexao = $this->conexao->prepare($update_query);
            $update_conexao->bindParam(":valor", $this->valor);
            $update_conexao->bindParam(":conta_id", $this->conta_id);
            $update_conexao->execute();
            
            return true;
        }

        return false;
    }
}
?>
