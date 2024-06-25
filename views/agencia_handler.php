<?php
require_once '../controllers/AgenciaController.php';

$controller = new AgenciaController();

$action = $_GET['action'];

switch ($action) {
    case 'create':
        $data = [
            'nome' => $_POST['nome'],
            'codigo' => $_POST['codigo'],
            'IDCIDADE' => $_POST['IDCIDADE']
        ];
        $controller->store($data);
        break;
    case 'update':
        $data = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'codigo' => $_POST['codigo'],
            'IDCIDADE' => $_POST['IDCIDADE']
        ];
        $controller->update($data);
        break;
    case 'delete':
        $id = $_POST['id'];
        $controller->delete($id);
        break;
}

header("Location: agencias.php");
exit();
?>
