<?php

require_once '../config/Database.php';
require_once '../models/TipoConta.php';

class TipoContaController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index()
    {
        $query = "SELECT tc.id, tc.nome, 
                         (SELECT COUNT(*) FROM contas c WHERE c.tipo = tc.id) as total_contas 
                  FROM tipo_conta tc";
        $conexao = $this->db->prepare($query);
        $conexao->execute();
        return $conexao->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($data)
    {
        $query = "INSERT INTO tipo_conta SET nome = :nome";
        $conexao = $this->db->prepare($query);
        $conexao->bindParam(":nome", $data['nome']);

        if ($conexao->execute()) {
            echo "Tipo de conta criado com sucesso.";
        } else {
            echo "Erro ao criar tipo de conta.";
        }
    }

    public function update($data)
    {
        $query = "UPDATE tipo_conta SET nome = :nome WHERE id = :id";
        $conexao = $this->db->prepare($query);
        $conexao->bindParam(':nome', $data['nome']);
        $conexao->bindParam(':id', $data['id']);

        if ($conexao->execute()) {
            echo "Tipo de conta atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar tipo de conta.";
        }
    }

    public function delete($id)
    {
        $query = "DELETE FROM tipo_conta WHERE id = :id";
        $conexao = $this->db->prepare($query);
        $conexao->bindParam(':id', $id);

        if ($conexao->execute()) {
            echo "Tipo de conta deletado com sucesso.";
        } else {
            echo "Erro ao deletar tipo de conta.";
        }
    }
}
?>
