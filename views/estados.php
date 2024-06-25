<?php
require_once './layout/header.php';
require_once '../controllers/EstadoController.php';

$controller = new EstadoController();
$estados = $controller->index();
?>
<section class="conteudo-dados-titulo">
    <h1 class="conteudo-dados-titulo-texto">Estados</h1>
</section>
<section class="conteudo-dados-novo">
    <button class="conteudo-dados-acao-novo" onclick="openDialog('dialog-novo-estado')">Novo</button>
</section>
<section class="conteudo-dados-tabela">
    <table>
        <thead>
            <tr class="tr-cabecalho">
                <th>ID</th>
                <th>Nome</th>
                <th>Sigla</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($estados)): ?>
                <?php foreach ($estados as $estado): ?>
                    <tr class="tr-registro">
                        <td><?php echo htmlspecialchars($estado['IDESTADO']); ?></td>
                        <td><?php echo htmlspecialchars($estado['NOME']); ?></td>
                        <td><?php echo htmlspecialchars($estado['SIGLA']); ?></td>
                        <td>
                            <button class="conteudo-dados-acao-editar" onclick="openEditDialog(
                                <?php echo htmlspecialchars($estado['IDESTADO']); ?>, 
                                '<?php echo htmlspecialchars($estado['NOME']); ?>', 
                                '<?php echo htmlspecialchars($estado['SIGLA']); ?>'
                            )">Editar</button>
                            <button class="conteudo-dados-acao-excluir" onclick="confirmDelete(<?php echo htmlspecialchars($estado['IDESTADO']); ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum estado encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Dialog para novo estado -->
<dialog id="dialog-novo-estado">
    <form method="post" action="estado_handler.php?action=create">
        <h2>Novo Estado</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="sigla">Sigla:</label>
        <input type="text" id="sigla" name="sigla" required>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-novo-estado')">Cancelar</button>
    </form>
</dialog>

<!-- Dialog para editar estado -->
<dialog id="dialog-editar-estado">
    <form method="post" action="estado_handler.php?action=update">
        <h2>Editar Estado</h2>
        <input type="hidden" id="editar_id" name="id">
        <label for="editar_nome">Nome:</label>
        <input type="text" id="editar_nome" name="nome" required>
        <label for="editar_sigla">Sigla:</label>
        <input type="text" id="editar_sigla" name="sigla" required>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-editar-estado')">Cancelar</button>
    </form>
</dialog>

<!-- Dialog para confirmar exclusão -->
<dialog id="dialog-confirmar-exclusao">
    <form method="post" action="estado_handler.php?action=delete">
        <h2>Excluir Estado</h2>
        <p>Tem certeza de que deseja excluir este estado?</p>
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

function openEditDialog(id, nome, sigla) {
    document.getElementById('editar_id').value = id;
    document.getElementById('editar_nome').value = nome;
    document.getElementById('editar_sigla').value = sigla;
    openDialog('dialog-editar-estado');
}

function confirmDelete(id) {
    document.getElementById('excluir_id').value = id;
    openDialog('dialog-confirmar-exclusao');
}
</script>
