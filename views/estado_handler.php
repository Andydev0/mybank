<?php
require_once '../controllers/EstadoController.php';

$controller = new EstadoController();

$action = $_GET['action'];

switch ($action) {
    case 'create':
        $data = [
            'nome' => $_POST['nome'],
            'sigla' => $_POST['sigla']
        ];
        $controller->store($data);
        break;

    case 'update':
        $data = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'sigla' => $_POST['sigla']
        ];
        $controller->update($data);
        break;

    case 'delete':
        $id = $_POST['id'];
        $controller->delete($id);
        break;
}

header("Location: estados.php");
exit();
?>
