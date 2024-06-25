<?php

require_once '../config/Database.php';
require_once '../models/Conta.php';

class ContaController {
    private $db;
    private $conta;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->conta = new Conta($this->db);
    }

    public function index() {
        $conexao = $this->conta->ler();
        $contas = $conexao->fetchAll(PDO::FETCH_ASSOC);
        return $contas;
    }

    public function store($data)
{
    $this->conta->cliente_id = $data['cliente_id'];
    $this->conta->agencia_id = $data['agencia_id'];
    $this->conta->numero_conta = $this->gerarNumeroConta(); // Gera o número da conta
    $this->conta->saldo = $data['saldo'];
    $this->conta->tipo = $data['tipo'];

    if ($this->conta->criar()) {
        echo json_encode(["success" => true, "message" => "Conta criada com sucesso."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao criar conta."]);
    }
}

private function gerarNumeroConta()
{
    return str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
}

}
?>
