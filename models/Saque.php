<?php

class Saque
{
    private $conexao;
    private $table_name = "saques";

    public $id;
    public $cliente_id;
    public $conta_id;
    public $valor;
    public $senha;
    public $data_hora;

    public function __construct($db)
    {
        $this->conexao = $db;
    }

    public function ler()
    {
        $query = "SELECT s.*, cl.NOME as CLIENTE_NOME, ag.CODIGO as AGENCIA_CODIGO, c.numero_conta, tc.nome as tipo_conta
                  FROM " . $this->table_name . " s
                  LEFT JOIN cliente cl ON s.cliente_id = cl.IDCLIENTE
                  LEFT JOIN contas c ON s.conta_id = c.id
                  LEFT JOIN agencia ag ON c.agencia_id = ag.IDAGENCIA
                  LEFT JOIN tipo_conta tc ON c.tipo = tc.id
                  ORDER BY s.data_hora DESC";
        $conexao = $this->conexao->prepare($query);
        $conexao->execute();
        return $conexao;
    }

    public function criar()
    {
        // Verifica a senha do cliente
        $senha_query = "SELECT senha FROM cliente WHERE IDCLIENTE = :cliente_id";
        $senha_conexao = $this->conexao->prepare($senha_query);
        $senha_conexao->bindParam(":cliente_id", $this->cliente_id);
        $senha_conexao->execute();
        $cliente_senha = $senha_conexao->fetch(PDO::FETCH_ASSOC);

        if (password_verify($this->senha, $cliente_senha['senha'])) {
            // Verifica o saldo da conta
            $saldo_query = "SELECT saldo FROM contas WHERE id = :conta_id";
            $saldo_conexao = $this->conexao->prepare($saldo_query);
            $saldo_conexao->bindParam(":conta_id", $this->conta_id);
            $saldo_conexao->execute();
            $conta_saldo = $saldo_conexao->fetch(PDO::FETCH_ASSOC);

            if ($conta_saldo['saldo'] >= $this->valor) {
                // Insere o saque e atualiza o saldo da conta
                $query = "INSERT INTO " . $this->table_name . " 
                          SET cliente_id = :cliente_id, conta_id = :conta_id, valor = :valor, senha = :senha, data_hora = :data_hora";
                $conexao = $this->conexao->prepare($query);

                $this->cliente_id = htmlspecialchars(strip_tags($this->cliente_id));
                $this->conta_id = htmlspecialchars(strip_tags($this->conta_id));
                $this->valor = htmlspecialchars(strip_tags($this->valor));
                $this->senha = htmlspecialchars(strip_tags($this->senha));
                $this->data_hora = htmlspecialchars(strip_tags($this->data_hora));

                $conexao->bindParam(":cliente_id", $this->cliente_id);
                $conexao->bindParam(":conta_id", $this->conta_id);
                $conexao->bindParam(":valor", $this->valor);
                $conexao->bindParam(":senha", $this->senha);
                $conexao->bindParam(":data_hora", $this->data_hora);

                if ($conexao->execute()) {
                    // Atualiza o saldo da conta
                    $update_query = "UPDATE contas SET saldo = saldo - :valor WHERE id = :conta_id";
                    $update_conexao = $this->conexao->prepare($update_query);
                    $update_conexao->bindParam(":valor", $this->valor);
                    $update_conexao->bindParam(":conta_id", $this->conta_id);
                    $update_conexao->execute();

                    return true;
                }
            } else {
                throw new Exception("Saldo insuficiente.");
            }
        } else {
            throw new Exception("Senha incorreta.");
        }

        return false;
    }
}
?>
