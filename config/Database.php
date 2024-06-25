<?php
class Database {
    private $host = "127.0.0.1";
    private $db_name = "u441253062_mybank";
    private $username = "u441253062_mybank";
    private $password = "mybankSenha123";
    public $conexao;

    public function getConnection() {
        $this->conexao = null;

        try {
            $this->conexao = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conexao->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conexao;
    }

    public function getCidades() {
        $query = "SELECT IDCIDADE, NOME FROM cidade ORDER BY NOME";
        $conexao = $this->getConnection();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClientes() {
        $query = "SELECT IDCLIENTE, NOME FROM cliente ORDER BY NOME";
        $conexao = $this->getConnection();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContas() {
        $query = "SELECT c.id, c.numero_conta, c.saldo, c.tipo, tc.nome as tipo_nome, c.cliente_id, cl.NOME AS CLIENTE_NOME, a.codigo AS AGENCIA_CODIGO 
                  FROM contas c 
                  JOIN cliente cl ON c.cliente_id = cl.IDCLIENTE 
                  JOIN agencia a ON c.agencia_id = a.IDAGENCIA
                  JOIN tipo_conta tc ON c.tipo = tc.id 
                  ORDER BY c.numero_conta";
        $conexao = $this->getConnection();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAgencias() {
        $query = "SELECT IDAGENCIA, NOME, CODIGO FROM agencia ORDER BY NOME";
        $conexao = $this->getConnection();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTiposDeContas() {
        $query = "SELECT id, nome FROM tipo_conta ORDER BY nome";
        $conexao = $this->getConnection();
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>
