<?php


class Conta {
    private $conexao;
    private $table_name = "contas";

    public $id;
    public $cliente_id;
    public $agencia_id;
    public $numero_conta;
    public $saldo;
    public $tipo;

    public function __construct($db) {
        $this->conexao = $db;
    }

    public function ler() {
        $query = "SELECT c.id, cl.NOME as CLIENTE_NOME, a.CODIGO as AGENCIA_CODIGO, c.numero_conta, c.saldo, tc.nome as tipo_conta
                  FROM " . $this->table_name . " c
                  JOIN cliente cl ON c.cliente_id = cl.IDCLIENTE
                  JOIN agencia a ON c.agencia_id = a.IDAGENCIA
                  JOIN tipo_conta tc ON c.tipo = tc.id";
        $conexao = $this->conexao->prepare($query);
        $conexao->execute();
        return $conexao;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET cliente_id=:cliente_id, agencia_id=:agencia_id, numero_conta=:numero_conta, saldo=:saldo, tipo=:tipo";
        $conexao = $this->conexao->prepare($query);

        $this->cliente_id = htmlspecialchars(strip_tags($this->cliente_id));
        $this->agencia_id = htmlspecialchars(strip_tags($this->agencia_id));
        $this->numero_conta = htmlspecialchars(strip_tags($this->numero_conta));
        $this->saldo = htmlspecialchars(strip_tags($this->saldo));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));

        $conexao->bindParam(":cliente_id", $this->cliente_id);
        $conexao->bindParam(":agencia_id", $this->agencia_id);
        $conexao->bindParam(":numero_conta", $this->numero_conta);
        $conexao->bindParam(":saldo", $this->saldo);
        $conexao->bindParam(":tipo", $this->tipo);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }
}

    

?>
