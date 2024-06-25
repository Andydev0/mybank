<?php
require_once '../controllers/ContaController.php';

$controller = new ContaController();

$action = $_GET['action'];

switch ($action) {
    case 'create':
        $data = [
            'cliente_id' => $_POST['cliente_id'],
            'agencia_id' => $_POST['agencia_id'],
            'numero_conta' => $_POST['numero_conta'],
            'saldo' => $_POST['saldo'],
            'tipo' => $_POST['tipo']
        ];
        $controller->store($data);
        break;
}

header("Location: contas.php");
exit();
?>
