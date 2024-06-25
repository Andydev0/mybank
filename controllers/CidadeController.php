<?php

require_once '../config/Database.php';
require_once '../models/Cidade.php';

class CidadeController
{
    private $db;
    private $cidade;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cidade = new Cidade($this->db);
    }

    public function index()
    {
        $conexao = $this->cidade->ler();
        $cidades = $conexao->fetchAll(PDO::FETCH_ASSOC);
        return $cidades;
    }

    public function store($data)
    {
        $this->cidade->nome = $data['nome'];
        $this->cidade->IDESTADO = $data['IDESTADO'];
        if ($this->cidade->criar()) {
            echo "Cidade criada com sucesso.";
        } else {
            echo "Erro ao criar cidade.";
        }
    }

    public function update($data)
    {
        $this->cidade->id = $data['id'];
        $this->cidade->nome = $data['nome'];
        $this->cidade->IDESTADO = $data['IDESTADO'];
        if ($this->cidade->atualizar()) {
            echo "Cidade atualizada com sucesso.";
        } else {
            echo "Erro ao atualizar cidade.";
        }
    }

    public function delete($id)
    {
        $this->cidade->id = $id;
        if ($this->cidade->deletar()) {
            echo "Cidade deletada com sucesso.";
        } else {
            echo "Erro ao deletar cidade.";
        }
    }
}
?>
