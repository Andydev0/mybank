<?php 
require_once 'layout/header.php'; 
require_once '../controllers/AgenciaController.php';
require_once '../config/Database.php';

$controller = new AgenciaController();
$agencias = $controller->index();

$database = new Database();
$cidades = $database->getCidades();
?>
<section class="conteudo-dados-titulo">
    <h1 class="conteudo-dados-titulo-texto">Agências</h1>
</section>
<section class="conteudo-dados-novo">
    <button class="conteudo-dados-acao-novo" onclick="openDialog('dialog-nova-agencia')">Novo</button>
</section>
<section class="conteudo-dados-tabela">
    <table>
        <thead>
            <tr class="tr-cabecalho">
                <th>#</th>
                <th>Nome</th>
                <th>Código</th>
                <th>Estado</th>
                <th>Cidade</th>
                <th>Clientes</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($agencias)): ?>
                <?php foreach ($agencias as $agencia): ?>
                    <tr class="tr-registro">
                        <td><?php echo htmlspecialchars($agencia['IDAGENCIA']); ?></td>
                        <td><?php echo htmlspecialchars($agencia['NOME']); ?></td>
                        <td><?php echo htmlspecialchars($agencia['CODIGO']); ?></td>
                        <td><?php echo htmlspecialchars($agencia['NOME_ESTADO']); ?></td>
                        <td><?php echo htmlspecialchars($agencia['NOME_CIDADE']); ?></td>
                        <td><?php echo htmlspecialchars($agencia['CLIENTES']); ?></td>
                        <td>
                            <button class="conteudo-dados-acao-editar" onclick="openEditDialog(
                                <?php echo htmlspecialchars($agencia['IDAGENCIA']); ?>, 
                                '<?php echo htmlspecialchars($agencia['NOME']); ?>', 
                                '<?php echo htmlspecialchars($agencia['CODIGO']); ?>', 
                                '<?php echo htmlspecialchars($agencia['IDCIDADE']); ?>'
                            )">Editar</button>
                            <button class="conteudo-dados-acao-excluir" onclick="confirmDelete(<?php echo htmlspecialchars($agencia['IDAGENCIA']); ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhuma agência encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Dialog para nova agência -->
<dialog id="dialog-nova-agencia">
    <form method="post" action="agencia_handler.php?action=create">
        <h2>Nova Agência</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required>
        <label for="IDCIDADE">Cidade:</label>
        <select id="IDCIDADE" name="IDCIDADE" required>
            <?php foreach ($cidades as $cidade): ?>
                <option value="<?php echo htmlspecialchars($cidade['IDCIDADE']); ?>"><?php echo htmlspecialchars($cidade['NOME']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-nova-agencia')">Cancelar</button>
    </form>
</dialog>

<!-- Dialog para editar agência -->
<dialog id="dialog-editar-agencia">
    <form method="post" action="agencia_handler.php?action=update">
        <h2>Editar Agência</h2>
        <input type="hidden" id="editar_id" name="id">
        <label for="editar_nome">Nome:</label>
        <input type="text" id="editar_nome" name="nome" required>
        <label for="editar_codigo">Código:</label>
        <input type="text" id="editar_codigo" name="codigo" required>
        <label for="editar_cidade_id">Cidade:</label>
        <select id="editar_cidade_id" name="IDCIDADE" required>
            <?php foreach ($cidades as $cidade): ?>
                <option value="<?php echo htmlspecialchars($cidade['IDCIDADE']); ?>"><?php echo htmlspecialchars($cidade['NOME']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-editar-agencia')">Cancelar</button>
    </form>
</dialog>

<!-- Dialog para confirmar exclusão -->
<dialog id="dialog-confirmar-exclusao">
    <form method="post" action="agencia_handler.php?action=delete">
        <h2>Excluir Agência</h2>
        <p>Tem certeza de que deseja excluir esta agência?</p>
        <input type="hidden" id="excluir_id" name="id">
        <button type="submit">Excluir</button>
        <button type="button" onclick="closeDialog('dialog-confirmar-exclusao')">Cancelar</button>
    </form>
</dialog>

<?php require_once 'layout/footer.php'; ?>

<script>
function openDialog(dialogId) {
    document.getElementById(dialogId).showModal();
}

function closeDialog(dialogId) {
    document.getElementById(dialogId).close();
}

function openEditDialog(id, nome, codigo, cidade_id) {
    document.getElementById('editar_id').value = id;
    document.getElementById('editar_nome').value = nome;
    document.getElementById('editar_codigo').value = codigo;
    document.getElementById('editar_cidade_id').value = cidade_id;
    openDialog('dialog-editar-agencia');
}

function confirmDelete(id) {
    document.getElementById('excluir_id').value = id;
    openDialog('dialog-confirmar-exclusao');
}
</script>
