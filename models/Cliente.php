<?php

class Cliente
{
    private $conexao;
    private $table_name = "cliente";

    public $id;
    public $nome;
    public $DTNASCIMENTO;
    public $CPF;
    public $DACCPF;
    public $email;
    public $IDCIDADE;
    public $senha;

    public function __construct($db)
    {
        $this->conexao = $db;
    }

    public function ler()
    {
        $query = "SELECT c.*, ci.NOME as NOME_CIDADE, e.SIGLA 
                  FROM " . $this->table_name . " c 
                  LEFT JOIN cidade ci ON c.IDCIDADE = ci.IDCIDADE 
                  LEFT JOIN estado e ON ci.IDESTADO = e.IDESTADO";
        $conexao = $this->conexao->prepare($query);
        $conexao->execute();
        return $conexao;
    }

    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET NOME=:nome, DTNASCIMENTO=:DTNASCIMENTO, CPF=:CPF, DACCPF=:DACCPF, EMAIL=:email, IDCIDADE=:IDCIDADE, SENHA=:senha";
        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->DTNASCIMENTO = htmlspecialchars(strip_tags($this->DTNASCIMENTO));
        $this->CPF = htmlspecialchars(strip_tags($this->CPF));
        $this->DACCPF = htmlspecialchars(strip_tags($this->DACCPF));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->IDCIDADE = htmlspecialchars(strip_tags($this->IDCIDADE));
        $this->senha = htmlspecialchars(strip_tags($this->senha));

        $conexao->bindParam(":nome", $this->nome);
        $conexao->bindParam(":DTNASCIMENTO", $this->DTNASCIMENTO);
        $conexao->bindParam(":CPF", $this->CPF);
        $conexao->bindParam(":DACCPF", $this->DACCPF);
        $conexao->bindParam(":email", $this->email);
        $conexao->bindParam(":IDCIDADE", $this->IDCIDADE);
        $conexao->bindParam(":senha", $this->senha);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET NOME = :nome, DTNASCIMENTO = :DTNASCIMENTO, CPF = :CPF, DACCPF = :DACCPF, EMAIL = :email, IDCIDADE = :IDCIDADE";
        if ($this->senha) {
            $query .= ", SENHA = :senha";
        }
        $query .= " WHERE IDCLIENTE = :id";

        $conexao = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->DTNASCIMENTO = htmlspecialchars(strip_tags($this->DTNASCIMENTO));
        $this->CPF = htmlspecialchars(strip_tags($this->CPF));
        $this->DACCPF = htmlspecialchars(strip_tags($this->DACCPF));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->IDCIDADE = htmlspecialchars(strip_tags($this->IDCIDADE));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->senha = htmlspecialchars(strip_tags($this->senha));

        $conexao->bindParam(':nome', $this->nome);
        $conexao->bindParam(':DTNASCIMENTO', $this->DTNASCIMENTO);
        $conexao->bindParam(':CPF', $this->CPF);
        $conexao->bindParam(':DACCPF', $this->DACCPF);
        $conexao->bindParam(':email', $this->email);
        $conexao->bindParam(':IDCIDADE', $this->IDCIDADE);
        $conexao->bindParam(':id', $this->id);
        if ($this->senha) {
            $conexao->bindParam(':senha', $this->senha);
        }

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    public function deletar()
    {
        // Exclua as contas associadas ao cliente antes de excluir o cliente
        $this->deletarContas();

        $query = "DELETE FROM " . $this->table_name . " WHERE IDCLIENTE = :id";
        $conexao = $this->conexao->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $conexao->bindParam(':id', $this->id);

        if ($conexao->execute()) {
            return true;
        }

        return false;
    }

    private function deletarContas()
    {
        $query = "DELETE FROM contas WHERE cliente_id = :id";
        $conexao = $this->conexao->prepare($query);
        $conexao->bindParam(':id', $this->id);
        $conexao->execute();
    }

    public function obterSenhaAtual()
    {
        $query = "SELECT SENHA FROM " . $this->table_name . " WHERE IDCLIENTE = :id";
        $conexao = $this->conexao->prepare($query);
        $conexao->bindParam(':id', $this->id);
        $conexao->execute();
        $row = $conexao->fetch(PDO::FETCH_ASSOC);
        return $row['SENHA'];
    }
}
?>
