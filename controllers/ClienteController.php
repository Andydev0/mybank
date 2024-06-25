<?php

require_once '../config/Database.php';
require_once '../models/Cliente.php';

class ClienteController
{
    private $db;
    private $cliente;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cliente = new Cliente($this->db);
    }

    public function index()
    {
        $conexao = $this->cliente->ler();
        $clientes = $conexao->fetchAll(PDO::FETCH_ASSOC);
        return $clientes;
    }

    public function store($data)
    {
        $this->cliente->nome = $data['nome'];
        $this->cliente->DTNASCIMENTO = $data['DTNASCIMENTO'];
        $this->cliente->CPF = $data['CPF'];
        $this->cliente->DACCPF = $data['DACCPF'];
        $this->cliente->email = $data['email'];
        $this->cliente->IDCIDADE = $data['IDCIDADE'];
        $this->cliente->senha = $data['senha'];

        if ($this->cliente->criar()) {
            echo "Cliente criado com sucesso.";
        } else {
            echo "Erro ao criar cliente.";
        }
    }

    public function update($data)
    {
        $this->cliente->id = $data['id'];
        $this->cliente->nome = $data['nome'];
        $this->cliente->DTNASCIMENTO = $data['DTNASCIMENTO'];
        $this->cliente->CPF = $data['CPF'];
        $this->cliente->DACCPF = $data['DACCPF'];
        $this->cliente->email = $data['email'];
        $this->cliente->IDCIDADE = $data['IDCIDADE'];

        // Verifique a senha atual
        $senha_atual_hash = $this->cliente->obterSenhaAtual();
        if (password_verify($data['senha_atual'], $senha_atual_hash)) {
            if (!empty($data['senha_nova'])) {
                $this->cliente->senha = password_hash($data['senha_nova'], PASSWORD_DEFAULT);
            }

            if ($this->cliente->atualizar()) {
                echo "Cliente atualizado com sucesso.";
            } else {
                echo "Erro ao atualizar cliente.";
            }
        } else {
            echo "Senha atual incorreta.";
        }
    }

    public function delete($id)
    {
        $this->cliente->id = $id;
        if ($this->cliente->deletar()) {
            echo "Cliente deletado com sucesso.";
        } else {
            echo "Erro ao deletar cliente.";
        }
    }
}
?>
