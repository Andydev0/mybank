<?php 
require_once 'layout/header.php'; 
require_once '../controllers/ClienteController.php';
require_once '../config/Database.php';

$controller = new ClienteController();
$clientes = $controller->index();

$database = new Database();
$cidades = $database->getCidades();
?>
<section class="conteudo-dados-titulo">
    <h1 class="conteudo-dados-titulo-texto">Clientes</h1>
</section>
<section class="conteudo-dados-novo">
    <button class="conteudo-dados-acao-novo" onclick="openDialog('dialog-novo-cliente')">Novo</button>
</section>
<section class="conteudo-dados-tabela">
    <table>
        <thead>
            <tr class="tr-cabecalho">
                <th>ID</th>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Cidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($clientes)): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr class="tr-registro">
                        <td><?php echo htmlspecialchars($cliente['IDCLIENTE']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['NOME']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($cliente['DTNASCIMENTO']))); ?></td>
                        <td><?php echo htmlspecialchars($cliente['CPF'] . '-' . $cliente['DACCPF']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['EMAIL']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['SIGLA']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['NOME_CIDADE']); ?></td>
                        <td>
                            <button class="conteudo-dados-acao-editar" onclick="openEditDialog(
                                <?php echo htmlspecialchars($cliente['IDCLIENTE']); ?>, 
                                '<?php echo htmlspecialchars($cliente['NOME']); ?>', 
                                '<?php echo htmlspecialchars($cliente['DTNASCIMENTO']); ?>', 
                                '<?php echo htmlspecialchars($cliente['CPF'] . '-' . $cliente['DACCPF']); ?>', 
                                '<?php echo htmlspecialchars($cliente['EMAIL']); ?>', 
                                '<?php echo htmlspecialchars($cliente['IDCIDADE']); ?>'
                            )">Editar</button>
                            <button class="conteudo-dados-acao-excluir" onclick="confirmDelete(<?php echo htmlspecialchars($cliente['IDCLIENTE']); ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Nenhum cliente encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Dialog para novo cliente -->
<dialog id="dialog-novo-cliente">
    <form id="form-novo-cliente" method="post" action="cliente_handler.php?action=create">
        <h2>Novo Cliente</h2>
        <div class="form-row">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div class="form-row">
            <label for="DTNASCIMENTO">Data de Nascimento:</label>
            <input type="date" id="DTNASCIMENTO" name="DTNASCIMENTO" required>
        </div>
        <div class="form-row">
            <label for="CPF_DACCPF">CPF:</label>
            <input type="text" id="CPF_DACCPF" name="CPF_DACCPF" maxlength="12" oninput="formatCPF(this)" required>
        </div>
        <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-row">
            <label for="IDCIDADE">Cidade:</label>
            <select id="IDCIDADE" name="IDCIDADE" required>
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?php echo htmlspecialchars($cidade['IDCIDADE']); ?>"><?php echo htmlspecialchars($cidade['NOME']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-row">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div class="form-actions">
            <button type="submit">Salvar</button>
            <button type="button" onclick="closeDialog('dialog-novo-cliente')">Cancelar</button>
        </div>
    </form>
</dialog>

<!-- Dialog para editar cliente -->
<dialog id="dialog-editar-cliente">
    <form id="form-editar-cliente" method="post" action="cliente_handler.php?action=update">
        <h2>Editar Cliente</h2>
        <input type="hidden" id="editar_id" name="id">
        <div class="form-row">
            <label for="editar_nome">Nome:</label>
            <input type="text" id="editar_nome" name="nome" required>
        </div>
        <div class="form-row">
            <label for="editar_DTNASCIMENTO">Data de Nascimento:</label>
            <input type="date" id="editar_DTNASCIMENTO" name="DTNASCIMENTO" required>
        </div>
        <div class="form-row">
            <label for="editar_CPF_DACCPF">CPF:</label>
            <input type="text" id="editar_CPF_DACCPF" name="CPF_DACCPF" maxlength="12" oninput="formatCPF(this)" required>
        </div>
        <div class="form-row">
            <label for="editar_email">Email:</label>
            <input type="email" id="editar_email" name="email" required>
        </div>
        <div class="form-row">
            <label for="editar_IDCIDADE">Cidade:</label>
            <select id="editar_IDCIDADE" name="IDCIDADE" required>
                <?php foreach ($cidades as $cidade): ?>
                    <option value="<?php echo htmlspecialchars($cidade['IDCIDADE']); ?>"><?php echo htmlspecialchars($cidade['NOME']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-row">
            <label for="senha_atual">Senha Atual:</label>
            <input type="password" id="senha_atual" name="senha_atual">
        </div>
        <div class="form-row">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha">
        </div>
        <div class="form-actions">
            <button type="submit">Salvar</button>
            <button type="button" onclick="closeDialog('dialog-editar-cliente')">Cancelar</button>
        </div>
    </form>
</dialog>

<!-- Dialog para confirmar exclusão -->
<dialog id="dialog-confirmar-exclusao">
    <form method="post" action="cliente_handler.php?action=delete">
        <h2>Excluir Cliente</h2>
        <p>Tem certeza de que deseja excluir este cliente?</p>
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

function openEditDialog(id, nome, DTNASCIMENTO, CPF_DACCPF, email, IDCIDADE) {
    document.getElementById('editar_id').value = id;
    document.getElementById('editar_nome').value = nome;
    document.getElementById('editar_DTNASCIMENTO').value = DTNASCIMENTO;
    document.getElementById('editar_CPF_DACCPF').value = CPF_DACCPF;
    document.getElementById('editar_email').value = email;
    document.getElementById('editar_IDCIDADE').value = IDCIDADE;
    openDialog('dialog-editar-cliente');
}

function confirmDelete(id) {
    document.getElementById('excluir_id').value = id;
    openDialog('dialog-confirmar-exclusao');
}

function formatCPF(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 9) value = value.slice(0, 9) + '-' + value.slice(9);
    input.value = value;
}

</script>

<style>
form {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

form h2 {
    width: 100%;
    text-align: center;
}

.form-row {
    width: 48%;
    margin-bottom: 10px;
}

.form-actions {
    width: 100%;
    display: flex;
    justify-content: space-between;
}
</style>
