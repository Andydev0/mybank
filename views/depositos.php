<?php 
require_once 'layout/header.php'; 
require_once '../controllers/DepositoController.php';
require_once '../config/Database.php';

$controller = new DepositoController();
$depositos = $controller->index();

$database = new Database();
$clientes = $database->getClientes();
$contas = $database->getContas();
?>
<section class="conteudo-dados-titulo">
    <h1 class="conteudo-dados-titulo-texto">Depósitos</h1>
</section>
<section class="conteudo-dados-novo">
    <button class="conteudo-dados-acao-novo" onclick="openDialog('dialog-novo-deposito')">Depositar</button>
</section>
<section class="conteudo-dados-tabela">
    <table>
        <thead>
            <tr class="tr-cabecalho">
                <th>Cliente</th>
                <th>Código da Agência</th>
                <th>Número da Conta</th>
                <th>Valor do Depósito</th>
                <th>Data e Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($depositos)): ?>
                <?php foreach ($depositos as $deposito): ?>
                    <tr class="tr-registro">
                        <td><?php echo htmlspecialchars($deposito['CLIENTE_NOME']); ?></td>
                        <td><?php echo htmlspecialchars($deposito['AGENCIA_CODIGO']); ?></td>
                        <td><?php echo htmlspecialchars($deposito['numero_conta']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($deposito['valor'], 2, ',', '.')); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y H:i:s', strtotime($deposito['data_hora']))); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum depósito encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Dialog para novo depósito -->
<dialog id="dialog-novo-deposito">
    <form method="post" action="deposito_handler.php?action=create">
        <h2>Novo Depósito</h2>
        <label for="cliente_id">Cliente:</label>
        <select id="cliente_id" name="cliente_id" required>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo htmlspecialchars($cliente['IDCLIENTE']); ?>"><?php echo htmlspecialchars($cliente['NOME']); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="conta_id">Conta:</label>
        <select id="conta_id" name="conta_id" required>
            <?php foreach ($contas as $conta): ?>
                <option value="<?php echo htmlspecialchars($conta['id']); ?>">
                    <?php echo htmlspecialchars($conta['numero_conta'] . ' - ' . $conta['tipo']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="valor">Valor:</label>
        <input type="number" step="0.01" id="valor" name="valor" required>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-novo-deposito')">Cancelar</button>
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
