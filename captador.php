<?php
session_start();
// Segurança: Apenas nível Captador pode acessar
if (!isset($_SESSION['id']) || $_SESSION['nivel'] != 'Captador') {
    header("Location: index.php");
    exit();
}

include 'header.php';
include 'php/db.php';

$id_usuario = $_SESSION['id'];

// Buscar apenas as indicações deste captador
$sql = "SELECT i.*, u.nome as nome_indicador 
        FROM imoveis i 
        JOIN usuarios u ON i.id_usuario = u.id 
        WHERE i.id_captador = ? 
        ORDER BY i.data_indicacao DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Painel de Captação</h2>
    
    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 10%;">Data/Tipo</th>
                        <th style="width: 15%;">Indicado por</th>
                        <th style="width: 25%;">Imóvel e Cliente</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 25%;">Observação / Feedback</th>
                        <th style="width: 10%;">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <small class="text-muted"><?php echo date('d/m/Y', strtotime($row['data_indicacao'])); ?></small><br>
                            <strong><?php echo htmlspecialchars($row['tipo']); ?></strong>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['nome_indicador']); ?></strong>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['nome_proprietario']); ?></strong><br>
                            <small class="d-block"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($row['contato_proprietario']); ?></small>
                            <small class="d-block text-muted text-wrap"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['endereco_imovel']); ?></small>
                        </td>
                        <td>
                            <!-- Select com ID único -->
                            <select id="status_<?php echo $row['id']; ?>" class="form-select form-select-sm">
                                <option value="Imóvel captado" <?php echo ($row['status'] == 'Imóvel captado') ? 'selected' : ''; ?>>Imóvel captado</option>
                                <option value="Imóvel alugado" <?php echo ($row['status'] == 'Imóvel alugado') ? 'selected' : ''; ?>>Imóvel alugado</option>
                                <option value="Imóvel vendido" <?php echo ($row['status'] == 'Imóvel vendido') ? 'selected' : ''; ?>>Imóvel vendido</option>
                                <option value="Fora área atuação da Acir" <?php echo ($row['status'] == 'Fora área atuação da Acir') ? 'selected' : ''; ?>>Fora área atuação da Acir</option>
                                <option value="Não conseguimos contato" <?php echo ($row['status'] == 'Não conseguimos contato') ? 'selected' : ''; ?>>Não conseguimos contato</option>
                                <option value="Não captado" <?php echo ($row['status'] == 'Não captado') ? 'selected' : ''; ?>>Não captado</option>
                                <option value="Em negociação" <?php echo ($row['status'] == 'Em negociação') ? 'selected' : ''; ?>>Em negociação</option>
                                <option value="Em contato" <?php echo ($row['status'] == 'Em contato') ? 'selected' : ''; ?>>Em contato</option>
                                <option value="Indicado" <?php echo ($row['status'] == 'Indicado') ? 'selected' : ''; ?>>Indicado</option>
                            </select>
                        </td>
                        <td>
                            <!-- Textarea com ID único -->
                            <textarea id="obs_<?php echo $row['id']; ?>" class="form-control form-control-sm" rows="3" placeholder="Insira o retorno aqui..."><?php echo htmlspecialchars($row['observacao'] ?? ''); ?></textarea>
                        </td>
                        <td class="text-center">
                            <!-- Botão chama função JS -->
                            <button type="button" onclick="salvarAlteracao(<?php echo $row['id']; ?>, '<?php echo $row['id_captador']; ?>')" class="btn btn-sm btn-primary">
                                <i class="bi bi-save"></i> Salvar
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulário Oculto Universal -->
        <form id="form_captador" action="php/atualizar_status.php" method="post" style="display:none;">
            <input type="hidden" name="id_imovel" id="hidden_id">
            <input type="hidden" name="id_captador" id="hidden_captador">
            <input type="hidden" name="status" id="hidden_status">
            <input type="hidden" name="observacao" id="hidden_obs">
            <input type="hidden" name="origem" value="captador"> <!-- Flag importante -->
        </form>

        <script>
        function salvarAlteracao(idImovel, idCaptador) {
            // 1. Pega os valores dos campos visíveis na linha
            var statusValor = document.getElementById('status_' + idImovel).value;
            var obsValor = document.getElementById('obs_' + idImovel).value;

            // 2. Joga para o formulário oculto
            document.getElementById('hidden_id').value = idImovel;
            document.getElementById('hidden_captador').value = idCaptador;
            document.getElementById('hidden_status').value = statusValor;
            document.getElementById('hidden_obs').value = obsValor;

            // 3. Envia
            document.getElementById('form_captador').submit();
        }
        </script>

    <?php else: ?>
        <div class="card text-center p-5">
            <div class="card-body">
                <h3>Tudo limpo!</h3>
                <p class="text-muted">Você não tem nenhuma indicação pendente no momento.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php 
$stmt->close();
$conn->close();
include 'footer.php'; 
?>