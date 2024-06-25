<?php

require_once '../config/Database.php';
require_once '../models/Deposito.php';

class DepositoController
{
    private $db;
    private $deposito;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->deposito = new Deposito($this->db);
    }

    public function index()
    {
        $conexao = $this->deposito->ler();
        $depositos = $conexao->fetchAll(PDO::FETCH_ASSOC);
        return $depositos;
    }

    public function store($data)
    {
        $this->deposito->cliente_id = $data['cliente_id'];
        $this->deposito->conta_id = $data['conta_id'];
        $this->deposito->valor = $data['valor'];
        $this->deposito->data_hora = date('Y-m-d H:i:s');

        if ($this->deposito->criar()) {
            echo json_encode(["success" => true, "message" => "Depósito realizado com sucesso."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao realizar depósito."]);
        }
    }
}
?>
