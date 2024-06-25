<?php

require_once '../config/Database.php';
require_once '../models/Estado.php';

class EstadoController
{
    private $db;
    private $estado;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->estado = new Estado($this->db);
    }

    public function index()
    {
        $conexao = $this->estado->ler();
        $estados = $conexao->fetchAll(PDO::FETCH_ASSOC);
        return $estados;
    }

    public function store($data)
    {
        $this->estado->nome = $data['nome'];
        $this->estado->sigla = $data['sigla'];
        if ($this->estado->criar()) {
            echo "Estado criado com sucesso.";
        } else {
            echo "Erro ao criar estado.";
        }
    }

    public function update($data)
    {
        $this->estado->id = $data['id'];
        $this->estado->nome = $data['nome'];
        $this->estado->sigla = $data['sigla'];
        if ($this->estado->atualizar()) {
            echo "Estado atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar estado.";
        }
    }

    public function delete($id)
    {
        $this->estado->id = $id;
        if ($this->estado->deletar()) {
            echo "Estado deletado com sucesso.";
        } else {
            echo "Erro ao deletar estado.";
        }
    }
}
?>
