<?php
require_once './layout/header.php';
require_once '../controllers/TipoContaController.php';

$controller = new TipoContaController();
$tiposDeContas = $controller->index();
?>
<section class="conteudo-dados-titulo">
    <h1 class="conteudo-dados-titulo-texto">Tipos de Contas</h1>
</section>
<section class="conteudo-dados-novo">
    <button class="conteudo-dados-acao-novo" onclick="openDialog('dialog-novo-tipo-conta')">Novo</button>
</section>
<section class="conteudo-dados-tabela">
    <table>
        <thead>
            <tr class="tr-cabecalho">
                <th>ID</th>
                <th>Nome</th>
                <th>Total de Contas</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tiposDeContas)): ?>
                <?php foreach ($tiposDeContas as $tipoConta): ?>
                    <tr class="tr-registro">
                        <td><?php echo htmlspecialchars($tipoConta['id']); ?></td>
                        <td><?php echo htmlspecialchars($tipoConta['nome']); ?></td>
                        <td><?php echo htmlspecialchars($tipoConta['total_contas']); ?></td>
                        <td>
                            <button class="conteudo-dados-acao-editar" onclick="openEditDialog(
                                <?php echo htmlspecialchars($tipoConta['id']); ?>, 
                                '<?php echo htmlspecialchars($tipoConta['nome']); ?>'
                            )">Editar</button>
                            <button class="conteudo-dados-acao-excluir" onclick="confirmDelete(<?php echo htmlspecialchars($tipoConta['id']); ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum tipo de conta encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Dialog para novo tipo de conta -->
<dialog id="dialog-novo-tipo-conta">
    <form method="post" action="tipo_conta_handler.php?action=create">
        <h2>Novo Tipo de Conta</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-novo-tipo-conta')">Cancelar</button>
    </form>
</dialog>

<!-- Dialog para editar tipo de conta -->
<dialog id="dialog-editar-tipo-conta">
    <form method="post" action="tipo_conta_handler.php?action=update">
        <h2>Editar Tipo de Conta</h2>
        <input type="hidden" id="editar_id" name="id">
        <label for="editar_nome">Nome:</label>
        <input type="text" id="editar_nome" name="nome" required>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-editar-tipo-conta')">Cancelar</button>
    </form>
</dialog>

<!-- Dialog para confirmar exclusão -->
<dialog id="dialog-confirmar-exclusao">
    <form method="post" action="tipo_conta_handler.php?action=delete">
        <h2>Excluir Tipo de Conta</h2>
        <p>Tem certeza de que deseja excluir este tipo de conta?</p>
        <input type="hidden" id="excluir_id" name="id">
        <button type="submit">Excluir</button>
        <button type="button" onclick="closeDialog('dialog-confirmar-exclusao')">Cancelar</button>
    </form>
</dialog>

<?php require_once './layout/footer.php'; ?>

<script>
function openDialog(dialogId) {
    document.getElementById(dialogId).showModal();
}

function closeDialog(dialogId) {
    document.getElementById(dialogId).close();
}

function openEditDialog(id, nome) {
    document.getElementById('editar_id').value = id;
    document.getElementById('editar_nome').value = nome;
    openDialog('dialog-editar-tipo-conta');
}

function confirmDelete(id) {
    document.getElementById('excluir_id').value = id;
    openDialog('dialog-confirmar-exclusao');
}
</script>
