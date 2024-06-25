<?php
require_once '../controllers/TipoContaController.php';

$controller = new TipoContaController();

$action = $_GET['action'];

switch ($action) {
    case 'create':
        $data = ['nome' => $_POST['nome']];
        $controller->store($data);
        break;
    case 'update':
        $data = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome']
        ];
        $controller->update($data);
        break;
    case 'delete':
        $id = $_POST['id'];
        $controller->delete($id);
        break;
}

header("location: tiposdecontas.php");
exit();
?>
