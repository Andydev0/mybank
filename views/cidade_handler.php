<?php
require_once '../controllers/CidadeController.php';

$controller = new CidadeController();

$action = $_GET['action'];

switch ($action) {
    case 'create':
        $data = [
            'nome' => $_POST['nome'],
            'IDESTADO' => $_POST['IDESTADO']
        ];
        $controller->store($data);
        break;

    case 'update':
        $data = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'IDESTADO' => $_POST['IDESTADO']
        ];
        $controller->update($data);
        break;

    case 'delete':
        $id = $_POST['id'];
        $controller->delete($id);
        break;
}

header("Location: cidades.php");
exit();
?>
