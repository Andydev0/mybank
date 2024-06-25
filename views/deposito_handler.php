<?php
require_once '../controllers/DepositoController.php';

$controller = new DepositoController();

$action = $_GET['action'];

switch ($action) {
    case 'create':
        $data = [
            'cliente_id' => $_POST['cliente_id'],
            'conta_id' => $_POST['conta_id'],
            'valor' => $_POST['valor']
        ];
        $controller->store($data);
        break;
}

header("Location: depositos.php");
exit();
?>
