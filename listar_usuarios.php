<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['nivel'] != 'Administrador') {
    header("Location: index.php");
    exit();
}
include 'header.php';
include 'php/db.php';

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<h2>Usuários Cadastrados</h2>
<?php if(isset($_GET['msg'])): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Departamento</th>
            <th>E-mail</th>
            <th>Nível</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nome']); ?></td>
            <td><?php echo htmlspecialchars($row['departamento']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['nivel']); ?></td>
            <td>
                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$conn->close();
include 'footer.php';
?>
