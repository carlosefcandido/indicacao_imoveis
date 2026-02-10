<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['nivel'] != 'Administrador') {
    header("Location: index.php");
    exit();
}
include 'header.php';
include 'php/db.php';

$sql = "SELECT i.*, u.nome as nome_usuario FROM imoveis i JOIN usuarios u ON i.id_usuario = u.id";
$where_clauses = [];
$params = [];
$types = '';

if (!empty($_GET['filtro_usuario'])) {
    $where_clauses[] = "u.nome LIKE ?";
    $params[] = '%' . $_GET['filtro_usuario'] . '%';
    $types .= 's';
}

if (!empty($_GET['filtro_status'])) {
    $where_clauses[] = "i.status = ?";
    $params[] = $_GET['filtro_status'];
    $types .= 's';
}

if (!empty($_GET['filtro_tipo'])) {
    $where_clauses[] = "i.tipo = ?";
    $params[] = $_GET['filtro_tipo'];
    $types .= 's';
}

if (!empty($_GET['filtro_departamento'])) {
    $where_clauses[] = "u.departamento = ?";
    $params[] = $_GET['filtro_departamento'];
    $types .= 's';
}

if (!empty($_GET['filtro_captador'])) {
    $where_clauses[] = "i.id_captador = ?";
    $params[] = $_GET['filtro_captador'];
    $types .= 'i';
}

if (isset($_GET['filtro_premiacao']) && $_GET['filtro_premiacao'] !== '') {
    $where_clauses[] = "i.premiacao_paga = ?";
    $params[] = $_GET['filtro_premiacao'];
    $types .= 'i';
}

if (!empty($_GET['filtro_data_inicio'])) {
    $where_clauses[] = "i.data_indicacao >= ?";
    $params[] = $_GET['filtro_data_inicio'];
    $types .= 's';
}

if (!empty($_GET['filtro_data_fim'])) {
    $data_fim_obj = new DateTime($_GET['filtro_data_fim']);
    $data_fim_obj->modify('+1 day');
    $data_fim_ajustada = $data_fim_obj->format('Y-m-d');
    $where_clauses[] = "i.data_indicacao < ?";
    $params[] = $data_fim_ajustada;
    $types .= 's';
}

if (count($where_clauses) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

$sql .= " ORDER BY i.data_indicacao DESC";

$stmt = $conn->prepare($sql);
if (count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Fetch distinct departments for the filter
$sql_departamentos = "SELECT DISTINCT departamento FROM usuarios ORDER BY departamento";
$result_departamentos = $conn->query($sql_departamentos);
$departamentos = [];
if ($result_departamentos->num_rows > 0) {
    while($row_dept = $result_departamentos->fetch_assoc()) {
        $departamentos[] = $row_dept['departamento'];
    }
}

// Fetch all users for captador selection (only those marked as captadores)
$sql_usuarios = "SELECT id, nome FROM usuarios WHERE nivel = 'Captador' OR eh_captador = 1 ORDER BY nome"; // Mantendo eh_captador como fallback temporário
$result_usuarios = $conn->query($sql_usuarios);
$usuarios_list = [];
if ($result_usuarios->num_rows > 0) {
    while($row_u = $result_usuarios->fetch_assoc()) {
        $usuarios_list[] = $row_u;
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            Filtrar Indicações
        </div>
        <div class="card-body">
            <form action="admin.php" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="filtro_usuario" class="form-label">Nome do Usuário:</label>
                    <input type="text" class="form-control" id="filtro_usuario" name="filtro_usuario" value="<?php echo htmlspecialchars($_GET['filtro_usuario'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label for="filtro_status" class="form-label">Status da Indicação:</label>
                    <select class="form-select" id="filtro_status" name="filtro_status">
                        <option value="">Todos</option>
                        <option value="Imóvel captado" <?php echo (($_GET['filtro_status'] ?? '') == 'Imóvel captado') ? 'selected' : ''; ?>>Imóvel captado</option>
                        <option value="Imóvel alugado" <?php echo (($_GET['filtro_status'] ?? '') == 'Imóvel alugado') ? 'selected' : ''; ?>>Imóvel alugado</option>
                        <option value="Imóvel vendido" <?php echo (($_GET['filtro_status'] ?? '') == 'Imóvel vendido') ? 'selected' : ''; ?>>Imóvel vendido</option>
                        <option value="Fora área atuação da Acir" <?php echo (($_GET['filtro_status'] ?? '') == 'Fora área atuação da Acir') ? 'selected' : ''; ?>>Fora área atuação da Acir</option>
                        <option value="Não conseguimos contato" <?php echo (($_GET['filtro_status'] ?? '') == 'Não conseguimos contato') ? 'selected' : ''; ?>>Não conseguimos contato</option>
                        <option value="Não captado" <?php echo (($_GET['filtro_status'] ?? '') == 'Não captado') ? 'selected' : ''; ?>>Não captado</option>
                        <option value="Em negociação" <?php echo (($_GET['filtro_status'] ?? '') == 'Em negociação') ? 'selected' : ''; ?>>Em negociação</option>
                        <option value="Em contato" <?php echo (($_GET['filtro_status'] ?? '') == 'Em contato') ? 'selected' : ''; ?>>Em contato</option>
                        <option value="Indicado" <?php echo (($_GET['filtro_status'] ?? '') == 'Indicado') ? 'selected' : ''; ?>>Indicado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtro_tipo" class="form-label">Tipo:</label>
                    <select class="form-select" id="filtro_tipo" name="filtro_tipo">
                        <option value="">Todos</option>
                        <option value="Venda" <?php echo (($_GET['filtro_tipo'] ?? '') == 'Venda') ? 'selected' : ''; ?>>Venda</option>
                        <option value="Locação" <?php echo (($_GET['filtro_tipo'] ?? '') == 'Locação') ? 'selected' : ''; ?>>Locação</option>
                        <option value="Condomínio" <?php echo (($_GET['filtro_tipo'] ?? '') == 'Condomínio') ? 'selected' : ''; ?>>Condomínio</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtro_departamento" class="form-label">Departamento:</label>
                    <select class="form-select" id="filtro_departamento" name="filtro_departamento">
                        <option value="">Todos</option>
                        <?php foreach ($departamentos as $departamento): ?>
                            <option value="<?php echo htmlspecialchars($departamento); ?>" <?php echo (($_GET['filtro_departamento'] ?? '') == $departamento) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($departamento); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtro_captador" class="form-label">Captador:</label>
                    <select class="form-select" id="filtro_captador" name="filtro_captador">
                        <option value="">Todos</option>
                        <?php foreach ($usuarios_list as $usuario): ?>
                            <option value="<?php echo $usuario['id']; ?>" <?php echo (($_GET['filtro_captador'] ?? '') == $usuario['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($usuario['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtro_premiacao" class="form-label">Premiação:</label>
                    <select class="form-select" id="filtro_premiacao" name="filtro_premiacao">
                        <option value="">Todos</option>
                        <option value="1" <?php echo (($_GET['filtro_premiacao'] ?? '') == '1') ? 'selected' : ''; ?>>Paga</option>
                        <option value="0" <?php echo (($_GET['filtro_premiacao'] ?? '') == '0') ? 'selected' : ''; ?>>Pendente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtro_data_inicio" class="form-label">Data Início:</label>
                    <input type="date" class="form-control" id="filtro_data_inicio" name="filtro_data_inicio" value="<?php echo htmlspecialchars($_GET['filtro_data_inicio'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label for="filtro_data_fim" class="form-label">Data Fim:</label>
                    <input type="date" class="form-control" id="filtro_data_fim" name="filtro_data_fim" value="<?php echo htmlspecialchars($_GET['filtro_data_fim'] ?? ''); ?>">
                </div>
                <div class="col-md-3 d-flex justify-content-end align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                    <a href="admin.php" class="btn btn-secondary">Limpar Filtros</a>
                </div>
            </form>
        </div>
    </div>
</div>

<h2 class="mt-4">Todas as Indicações</h2>
<?php if(isset($_GET['msg'])): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>
<?php if ($result->num_rows > 0): ?>
<div class="table-responsive">
<table class="table table-striped table-hover table-bordered align-middle admin-indicacoes-table">
    <thead class="table-dark">
        <tr>
            <th style="width: 100px;">Data/Tipo</th>
            <th>Origem/Captador</th>
            <th>Imóvel e Cliente</th>
            <th style="width: 200px;">Status e Pagto</th>
            <th>Observação de Retorno</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <!-- Coluna Data e Tipo -->
        <td>
            <small class="text-muted"><?php echo date('d/m/Y', strtotime($row['data_indicacao'])); ?></small><br>
            <strong><?php echo htmlspecialchars($row['tipo']); ?></strong>
        </td>

        <!-- Coluna Pessoas (Quem indicou e Captador) -->
        <td>
            <div class="col-12">
                <small class="text-muted d-block">Indicado por:</small>
                <strong><?php echo htmlspecialchars($row['nome_usuario']); ?></strong>
            </div>
            <div class="col-12 mt-2">
                <small class="text-muted d-block">Captador Responsável:</small>
                <select id="captador_<?php echo $row['id']; ?>" class="form-select form-select-sm">
                    <option value="">Selecionar...</option>
                    <?php foreach ($usuarios_list as $usuario): ?>
                        <option value="<?php echo $usuario['id']; ?>" <?php echo ($row['id_captador'] == $usuario['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($usuario['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </td>

        <!-- Coluna Detalhes do Imóvel -->
        <td>
            <strong><?php echo htmlspecialchars($row['nome_proprietario']); ?></strong><br>
            <small class="d-block text-truncate" style="max-width: 250px;" title="<?php echo htmlspecialchars($row['contato_proprietario']); ?>">
                <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($row['contato_proprietario']); ?>
            </small>
            <small class="d-block text-muted text-wrap">
                <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['endereco_imovel']); ?>
            </small>
        </td>

        <!-- Coluna Status e Financeiro -->
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
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="paga_<?php echo $row['id']; ?>" value="1" <?php echo ($row['premiacao_paga'] == 1) ? 'checked' : ''; ?>>
                <label class="form-check-label small" for="paga_<?php echo $row['id']; ?>">
                    Premiação Paga
                </label>
            </div>
        </td>

        <!-- Coluna Observação -->
        <td>
            <textarea id="obs_<?php echo $row['id']; ?>" class="form-control form-control-sm" rows="3" placeholder="Feedback para o indicador..."><?php echo htmlspecialchars($row['observacao'] ?? ''); ?></textarea>
        </td>

        <!-- Coluna Ação -->
        <td class="text-center">
            <button type="button" onclick="atualizarAdmin(<?php echo $row['id']; ?>)" class="btn btn-sm btn-success w-100">Salvar</button>
        </td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>

<!-- Formulário oculto para envio via JS (Admin) -->
<form id="form_admin_atualizar" action="php/atualizar_status.php" method="post" style="display:none;">
    <input type="hidden" name="id_imovel" id="hidden_id_imovel">
    <input type="hidden" name="id_captador" id="hidden_id_captador">
    <input type="hidden" name="status" id="hidden_status">
    <input type="hidden" name="observacao" id="hidden_observacao">
    <input type="hidden" name="premiacao_paga" id="hidden_premiacao_paga">
</form>

<script>
function atualizarAdmin(idImovel) {
    document.getElementById('hidden_id_imovel').value = idImovel;
    document.getElementById('hidden_id_captador').value = document.getElementById('captador_' + idImovel).value;
    document.getElementById('hidden_status').value = document.getElementById('status_' + idImovel).value;
    document.getElementById('hidden_observacao').value = document.getElementById('obs_' + idImovel).value;
    
    // Checkbox requires special handling
    if (document.getElementById('paga_' + idImovel).checked) {
        document.getElementById('hidden_premiacao_paga').value = "1";
    } else {
        document.getElementById('hidden_premiacao_paga').value = "0"; // Or empty, but 0 is clearer
    }
    
    document.getElementById('form_admin_atualizar').submit();
}
</script>
<?php else: ?>
    <div class="alert alert-warning">Nenhuma indicação encontrada.</div>
<?php endif; ?>

<?php
$conn->close();
include 'footer.php';
?>
