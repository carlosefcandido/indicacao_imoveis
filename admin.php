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
<table class="table table-striped table-hover table-bordered align-middle">
    <thead>
        <tr>
            <th>Usuário</th>
            <th>Tipo</th>
            <th>Cliente</th>
            <th>Contato</th>
            <th>Endereço</th>
            <th>Status</th>
            <th>Data</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['nome_usuario']); ?></td>
        <td><?php echo htmlspecialchars($row['tipo']); ?></td>
        <td><?php echo htmlspecialchars($row['nome_proprietario']); ?></td>
        <td><?php echo htmlspecialchars($row['contato_proprietario']); ?></td>
        <td><?php echo htmlspecialchars($row['endereco_imovel']); ?></td>
        <td>
            <form action="php/atualizar_status.php" method="post">
                <input type="hidden" name="id_imovel" value="<?php echo $row['id']; ?>">
                <select name="status" class="form-select">
                    <option value="Imóvel captado" <?php echo ($row['status'] == 'Imóvel captado') ? 'selected' : ''; ?>>Imóvel captado</option>
                    <option value="Imóvel alugado" <?php echo ($row['status'] == 'Imóvel alugado') ? 'selected' : ''; ?>>Imóvel alugado</option>
                    <option value="Imóvel vendido" <?php echo ($row['status'] == 'Imóvel vendido') ? 'selected' : ''; ?>>Imóvel vendido</option>
                    <option value="Fora área atuação da Acir" <?php echo ($row['status'] == 'Fora área atuação da Acir') ? 'selected' : ''; ?>>Fora área atuação da Acir</option>
                    <option value="Não conseguimos contato" <?php echo ($row['status'] == 'Não conseguimos contato') ? 'selected' : ''; ?>>Não conseguimos contato</option>
                    <option value="Não captado" <?php echo ($row['status'] == 'Não captado') ? 'selected' : ''; ?>>Não captado</option>
                    <option value="Indicado" <?php echo ($row['status'] == 'Indicado') ? 'selected' : ''; ?>>Indicado</option>
                </select>
        </td>
        <td><?php echo date('d/m/Y', strtotime($row['data_indicacao'])); ?></td>
        <td>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="alert alert-warning">Nenhuma indicação encontrada.</div>
<?php endif; ?>

<?php
$conn->close();
include 'footer.php';
?>
