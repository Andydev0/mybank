<?php

require_once '../config/Database.php';
require_once '../models/Saque.php';

class SaqueController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index()
    {
        $saque = new Saque($this->db);
        $conexao = $saque->ler();
        return $conexao->fetchAll(PDO::FETCH_ASSOC);
    }

    public function store($data)
    {
        $saque = new Saque($this->db);
        $saque->cliente_id = $data['cliente_id'];
        $saque->conta_id = $data['conta_id'];
        $saque->valor = $data['valor'];
        $saque->senha = $data['senha'];
        $saque->data_hora = date('Y-m-d H:i:s');

        try {
            if ($saque->criar()) {
                echo json_encode(["success" => true, "message" => "Saque realizado com sucesso."]);
            } else {
                echo json_encode(["success" => false, "message" => "Erro ao realizar saque."]);
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
}
?>
