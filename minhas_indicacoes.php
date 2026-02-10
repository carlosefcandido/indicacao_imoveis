<?php
session_start();
if (!isset($_SESSION['id']) || (($_SESSION['eh_captador'] ?? 0) == 1 && $_SESSION['nivel'] != 'Administrador')) {
    header("Location: home.php");
    exit();
}
include 'header.php';
include 'php/db.php';

$id_usuario = $_SESSION['id'];
$sql = "SELECT i.*, u.nome as nome_captador 
        FROM imoveis i 
        LEFT JOIN usuarios u ON i.id_captador = u.id 
        WHERE i.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Minhas Indicações</h2>
<?php if(isset($_GET['msg'])): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>
<?php if ($result->num_rows > 0): ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Cliente</th>
            <th>Contato</th>
            <th>Endereço</th>
            <th>Captador</th>
            <th>Status</th>
            <th>Premiação</th>
            <th>Observação</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['tipo']); ?></td>
            <td><?php echo htmlspecialchars($row['nome_proprietario']); ?></td>
            <td><?php echo htmlspecialchars($row['contato_proprietario']); ?></td>
            <td><?php echo htmlspecialchars($row['endereco_imovel']); ?></td>
            <td><?php echo htmlspecialchars($row['nome_captador'] ?? 'Aguardando'); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
                <?php if($row['premiacao_paga']): ?>
                    <span class="badge bg-success">Paga</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark">Pendente</span>
                <?php endif; ?>
            </td>
            <td><?php echo nl2br(htmlspecialchars($row['observacao'] ?? '')); ?></td>
            <td><?php echo date('d/m/Y', strtotime($row['data_indicacao'])); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="alert alert-warning">Você ainda não fez nenhuma indicação.</div>
<?php endif; ?>

<?php
$stmt->close();
$conn->close();
include 'footer.php';
?>
