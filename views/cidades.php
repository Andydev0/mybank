<?php
require_once './layout/header.php';
require_once '../controllers/CidadeController.php';
require_once '../config/Database.php';

$controller = new CidadeController();
$cidades = $controller->index();

$database = new Database();
$db = $database->getConnection();
$query = "SELECT * FROM estado";
$stmt = $db->prepare($query);
$stmt->execute();
$estados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="conteudo-dados-titulo">
    <h1 class="conteudo-dados-titulo-texto">Cidades</h1>
</section>
<section class="conteudo-dados-novo">
    <button class="conteudo-dados-acao-novo" onclick="openDialog('dialog-nova-cidade')">Novo</button>
</section>
<section class="conteudo-dados-tabela">
    <table>
        <thead>
            <tr class="tr-cabecalho">
                <th>ID</th>
                <th>Nome</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cidades)): ?>
                <?php foreach ($cidades as $cidade): ?>
                    <tr class="tr-registro">
                        <td><?php echo htmlspecialchars($cidade['IDCIDADE']); ?></td>
                        <td><?php echo htmlspecialchars($cidade['NOME']); ?></td>
                        <td><?php echo htmlspecialchars($cidade['ESTADO_NOME']); ?></td>
                        <td>
                            <button class="conteudo-dados-acao-editar" onclick="openEditDialog(
                                <?php echo htmlspecialchars($cidade['IDCIDADE']); ?>, 
                                '<?php echo htmlspecialchars($cidade['NOME']); ?>', 
                                '<?php echo htmlspecialchars($cidade['IDESTADO']); ?>'
                            )">Editar</button>
                            <button class="conteudo-dados-acao-excluir" onclick="confirmDelete(<?php echo htmlspecialchars($cidade['IDCIDADE']); ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhuma cidade encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Dialog para nova cidade -->
<dialog id="dialog-nova-cidade">
    <form method="post" action="cidade_handler.php?action=create">
        <h2>Nova Cidade</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="IDESTADO">Estado:</label>
        <select id="IDESTADO" name="IDESTADO" required>
            <?php foreach ($estados as $estado): ?>
                <option value="<?php echo htmlspecialchars($estado['IDESTADO']); ?>"><?php echo htmlspecialchars($estado['NOME']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-nova-cidade')">Cancelar</button>
    </form>
</dialog>

<!-- Dialog para editar cidade -->
<dialog id="dialog-editar-cidade">
    <form method="post" action="cidade_handler.php?action=update">
        <h2>Editar Cidade</h2>
        <input type="hidden" id="editar_id" name="id">
        <label for="editar_nome">Nome:</label>
        <input type="text" id="editar_nome" name="nome" required>
        <label for="editar_estado_id">Estado:</label>
        <select id="editar_estado_id" name="IDESTADO" required>
            <?php foreach ($estados as $estado): ?>
                <option value="<?php echo htmlspecialchars($estado['IDESTADO']); ?>"><?php echo htmlspecialchars($estado['NOME']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-editar-cidade')">Cancelar</button>
    </form>
</dialog>

<!-- Dialog para confirmar exclusão -->
<dialog id="dialog-confirmar-exclusao">
    <form method="post" action="cidade_handler.php?action=delete">
        <h2>Excluir Cidade</h2>
        <p>Tem certeza de que deseja excluir esta cidade?</p>
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

function openEditDialog(id, nome, estado_id) {
    document.getElementById('editar_id').value = id;
    document.getElementById('editar_nome').value = nome;
    document.getElementById('editar_estado_id').value = estado_id;
    openDialog('dialog-editar-cidade');
}

function confirmDelete(id) {
    document.getElementById('excluir_id').value = id;
    openDialog('dialog-confirmar-exclusao');
}
</script>
