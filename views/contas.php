<?php 
require_once 'layout/header.php'; 
require_once '../controllers/ContaController.php';
require_once '../config/Database.php';

$controller = new ContaController();
$contas = $controller->index();

$database = new Database();
$clientes = $database->getClientes();
$agencias = $database->getAgencias();
$tiposDeContas = $database->getTiposDeContas(); // Adicione este método ao Database.php se ainda não existir
?>
<section class="conteudo-dados-titulo">
    <h1 class="conteudo-dados-titulo-texto">Contas</h1>
</section>
<section class="conteudo-dados-novo">
    <button class="conteudo-dados-acao-novo" onclick="openDialog('dialog-nova-conta')">Nova Conta</button>
</section>
<section class="conteudo-dados-tabela">
    <table>
        <thead>
            <tr class="tr-cabecalho">
                <th>ID</th>
                <th>Cliente</th>
                <th>Agência</th>
                <th>Número da Conta</th>
                <th>Saldo</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($contas)): ?>
                <?php foreach ($contas as $conta): ?>
                    <tr class="tr-registro">
                        <td><?php echo htmlspecialchars($conta['id']); ?></td>
                        <td><?php echo htmlspecialchars($conta['CLIENTE_NOME']); ?></td>
                        <td><?php echo htmlspecialchars($conta['AGENCIA_CODIGO']); ?></td>
                        <td><?php echo htmlspecialchars($conta['numero_conta']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($conta['saldo'], 2, ',', '.')); ?></td>
                        <td><?php echo htmlspecialchars($conta['tipo_conta']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhuma conta encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Dialog para nova conta -->
<dialog id="dialog-nova-conta">
    <form method="post" action="conta_handler.php?action=create">
        <h2>Nova Conta</h2>
        <label for="cliente_id">Cliente:</label>
        <select id="cliente_id" name="cliente_id" required>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo htmlspecialchars($cliente['IDCLIENTE']); ?>"><?php echo htmlspecialchars($cliente['NOME']); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="agencia_id">Agência:</label>
        <select id="agencia_id" name="agencia_id" required>
            <?php foreach ($agencias as $agencia): ?>
                <option value="<?php echo htmlspecialchars($agencia['IDAGENCIA']); ?>"><?php echo htmlspecialchars($agencia['CODIGO'] . ' - ' . $agencia['NOME']); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="saldo">Saldo Inicial:</label>
        <input type="number" step="0.01" id="saldo" name="saldo" required>
        <label for="tipo">Tipo de Conta:</label>
        <select id="tipo" name="tipo" required>
            <?php foreach ($tiposDeContas as $tipoConta): ?>
                <option value="<?php echo htmlspecialchars($tipoConta['id']); ?>"><?php echo htmlspecialchars($tipoConta['nome']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-nova-conta')">Cancelar</button>
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
</script>
