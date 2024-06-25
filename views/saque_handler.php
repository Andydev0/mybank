<?php

require_once '../controllers/SaqueController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'];
    $controller = new SaqueController();

    if ($action === 'create') {
        $data = [
            'cliente_id' => $_POST['cliente_id'],
            'conta_id' => $_POST['conta_id'],
            'valor' => $_POST['valor'],
            'senha' => $_POST['senha']
        ];
        $controller->store($data);
    }
}
?>
