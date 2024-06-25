<?php

require_once '../controllers/ClienteController.php';

$controller = new ClienteController();

$action = $_GET['action'];

switch ($action) {
    case 'create':
        $data = [
            'nome' => $_POST['nome'],
            'DTNASCIMENTO' => $_POST['DTNASCIMENTO'],
            'CPF' => substr($_POST['CPF_DACCPF'], 0, 9),
            'DACCPF' => substr($_POST['CPF_DACCPF'], -2),
            'email' => $_POST['email'],
            'IDCIDADE' => $_POST['IDCIDADE'],
            'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
        ];
        $controller->store($data);
        break;
    case 'update':
        $data = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'DTNASCIMENTO' => $_POST['DTNASCIMENTO'],
            'CPF' => substr($_POST['CPF_DACCPF'], 0, 9),
            'DACCPF' => substr($_POST['CPF_DACCPF'], -2),
            'email' => $_POST['email'],
            'IDCIDADE' => $_POST['IDCIDADE'],
            'senha_atual' => $_POST['senha_atual']
        ];

        if (!empty($_POST['senha_nova'])) {
            $data['senha_nova'] = $_POST['senha_nova'];
        }

        $controller->update($data);
        break;
    case 'delete':
        $id = $_POST['id'];
        $controller->delete($id);
        break;
}
header("Location: clientes.php");
exit();
?>
