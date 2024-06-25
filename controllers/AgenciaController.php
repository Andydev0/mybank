<?php

require_once '../config/Database.php';
require_once '../models/Agencia.php';

class AgenciaController
{
    private $db;
    private $agencia;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->agencia = new Agencia($this->db);
    }

    public function index()
    {
        $conexao = $this->agencia->ler();
        $agencias = $conexao->fetchAll(PDO::FETCH_ASSOC);
        return $agencias;
    }

    public function store($data)
    {
        $this->agencia->nome = $data['nome'];
        $this->agencia->codigo = $data['codigo'];
        $this->agencia->cidade_id = $data['IDCIDADE'];
        if ($this->agencia->criar()) {
            echo "Agência criada com sucesso.";
        } else {
            echo "Erro ao criar agência.";
        }
    }

    public function update($data)
    {
        $this->agencia->id = $data['id'];
        $this->agencia->nome = $data['nome'];
        $this->agencia->codigo = $data['codigo'];
        $this->agencia->cidade_id = $data['IDCIDADE'];
        if ($this->agencia->atualizar()) {
            echo "Agência atualizada com sucesso.";
        } else {
            echo "Erro ao atualizar agência.";
        }
    }

    public function delete($id)
    {
        $this->agencia->id = $id;
        if ($this->agencia->deletar()) {
            echo "Agência deletada com sucesso.";
        } else {
            echo "Erro ao deletar agência.";
        }
    }
}
?>
