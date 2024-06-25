<?php 
require_once 'layout/header.php'; 
require_once '../controllers/SaqueController.php';
require_once '../config/Database.php';

$controller = new SaqueController();
$saques = $controller->index();

$database = new Database();
$clientes = $database->getClientes();
$contas = $database->getContas();
?>
<section class="conteudo-dados-titulo">
    <h1 class="conteudo-dados-titulo-texto">Saques</h1>
</section>
<section class="conteudo-dados-novo">
    <button class="conteudo-dados-acao-novo" onclick="openDialog('dialog-novo-saque')">Sacar</button>
</section>
<section class="conteudo-dados-tabela">
    <table>
        <thead>
            <tr class="tr-cabecalho">
                <th>Cliente</th>
                <th>Código da Agência</th>
                <th>Número da Conta</th>
                <th>Valor do Saque</th>
                <th>Data e Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($saques)): ?>
                <?php foreach ($saques as $saque): ?>
                    <tr class="tr-registro">
                        <td><?php echo htmlspecialchars($saque['CLIENTE_NOME']); ?></td>
                        <td><?php echo htmlspecialchars($saque['AGENCIA_CODIGO']); ?></td>
                        <td><?php echo htmlspecialchars($saque['numero_conta']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($saque['valor'], 2, ',', '.')); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y H:i:s', strtotime($saque['data_hora']))); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum saque encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<!-- Dialog para novo saque -->
<dialog id="dialog-novo-saque">
    <form method="post" action="saque_handler.php?action=create">
        <h2>Novo Saque</h2>
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
                    <?php echo htmlspecialchars($conta['numero_conta'] . ' - ' . $conta['AGENCIA_CODIGO']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="tipo_conta_label">Tipo de Conta:</label>
        <span id="tipo_conta_label"></span>
        <label for="valor">Valor:</label>
        <input type="number" step="0.01" id="valor" name="valor" required>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <button type="submit">Salvar</button>
        <button type="button" onclick="closeDialog('dialog-novo-saque')">Cancelar</button>
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

document.getElementById('cliente_id').addEventListener('change', function() {
    var cliente_id = this.value;
    var contas = <?php echo json_encode($contas); ?>;
    var contaSelect = document.getElementById('conta_id');
    contaSelect.innerHTML = '';

    contas.forEach(function(conta) {
        if (conta.cliente_id == cliente_id) {
            var option = document.createElement('option');
            option.value = conta.id;
            option.text = conta.numero_conta + ' - ' + conta.AGENCIA_CODIGO;
            contaSelect.appendChild(option);
        }
    });
});

document.getElementById('conta_id').addEventListener('change', function() {
    var conta_id = this.value;
    var contas = <?php echo json_encode($contas); ?>;
    var tipoContaLabel = document.getElementById('tipo_conta_label');

    contas.forEach(function(conta) {
        if (conta.id == conta_id) {
            tipoContaLabel.textContent = conta.tipo;
        }
    });
});
</script>
