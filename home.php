<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
include 'header.php';
include 'php/db.php';

$id_usuario = $_SESSION['id'];
$eh_captador = $_SESSION['eh_captador'] ?? 0;

if ($eh_captador): 
    // Buscar indicações atribuídas a este captador
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
    <h2 class="mb-4">Indicações para Minha Captação</h2>
    
    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Data/Tipo</th>
                        <th>Indicado por</th>
                        <th>Imóvel e Cliente</th>
                        <th style="width: 200px;">Status</th>
                        <th>Minhas Observações</th>
                        <th>Ação</th>
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
                            <select id="status_<?php echo $row['id']; ?>" class="form-select form-select-sm mb-2">
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

                            <?php if($row['premiacao_paga']): ?>
                                <span class="badge bg-success d-block mb-1">Premiação Paga</span>
                            <?php else: ?>
                                <span class="badge bg-secondary d-block mb-1">Premiação Pendente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <textarea id="obs_<?php echo $row['id']; ?>" class="form-control form-control-sm" rows="2"><?php echo htmlspecialchars($row['observacao'] ?? ''); ?></textarea>
                        </td>
                        <td>
                            <button type="button" onclick="atualizarImovel(<?php echo $row['id']; ?>, '<?php echo $row['id_captador']; ?>')" class="btn btn-sm btn-success w-100">Atualizar</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulário oculto para envio via JS -->
        <form id="form_atualizar" action="php/atualizar_status.php" method="post" style="display:none;">
            <input type="hidden" name="id_imovel" id="hidden_id_imovel">
            <input type="hidden" name="id_captador" id="hidden_id_captador">
            <input type="hidden" name="status" id="hidden_status">
            <input type="hidden" name="observacao" id="hidden_observacao">
            <input type="hidden" name="origem" value="home">
        </form>

        <script>
        function atualizarImovel(idImovel, idCaptador) {
            document.getElementById('hidden_id_imovel').value = idImovel;
            document.getElementById('hidden_id_captador').value = idCaptador;
            document.getElementById('hidden_status').value = document.getElementById('status_' + idImovel).value;
            document.getElementById('hidden_observacao').value = document.getElementById('obs_' + idImovel).value;
            document.getElementById('form_atualizar').submit();
        }
        </script>
    <?php else: ?>
        <div class="alert alert-warning">Você não possui nenhuma indicação atribuída para captação no momento.</div>
    <?php endif; ?>

<?php else: ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2>Cadastro de Indicação</h2>
            </div>
            <div class="card-body">
                <?php if(isset($_GET['msg'])): ?>
                    <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
                <?php endif; ?>
                <form action="php/cadastrar_imovel.php" method="post">
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="Venda">Venda</option>
                            <option value="Locação">Locação</option>
                            <option value="Condomínio">Condomínio</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nome_proprietario" class="form-label">Nome do Cliente</label>
                        <input type="text" class="form-control" id="nome_proprietario" name="nome_proprietario" required>
                    </div>
                    <div class="mb-3">
                        <label for="contato_proprietario" class="form-label">Contato do Cliente</label>
                        <input type="text" class="form-control" id="contato_proprietario" name="contato_proprietario" required>
                    </div>
                    <div class="mb-3">
                        <label for="endereco_imovel" class="form-label">Endereço</label>
                        <textarea class="form-control" id="endereco_imovel" name="endereco_imovel" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Indicar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php 
if(isset($stmt)) $stmt->close();
$conn->close();
include 'footer.php'; 
?>
