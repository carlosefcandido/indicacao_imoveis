<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['nivel'] != 'Administrador') {
    header("Location: index.php");
    exit();
}
include 'header.php';
include 'php/db.php';

$id_usuario = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2>Editar Usuário</h2>
            </div>
            <div class="card-body">
                <form action="php/atualizar_usuario.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="departamento" class="form-label">Departamento</label>
                        <select class="form-select" id="departamento" name="departamento" required>
                            <option value="Contas a Pagar" <?php echo ($usuario['departamento'] == 'Contas a Pagar') ? 'selected' : ''; ?>>Contas a Pagar</option>
                            <option value="Contas a Receber" <?php echo ($usuario['departamento'] == 'Contas a Receber') ? 'selected' : ''; ?>>Contas a Receber</option>
                            <option value="Fiscal" <?php echo ($usuario['departamento'] == 'Fiscal') ? 'selected' : ''; ?>>Fiscal</option>
                            <option value="Financeiro" <?php echo ($usuario['departamento'] == 'Financeiro') ? 'selected' : ''; ?>>Financeiro</option>
                            <option value="Captação Condomínios" <?php echo ($usuario['departamento'] == 'Captação Condomínios') ? 'selected' : ''; ?>>Captação Condomínios</option>
                            <option value="Contabilidade" <?php echo ($usuario['departamento'] == 'Contabilidade') ? 'selected' : ''; ?>>Contabilidade</option>
                            <option value="Departamento Pessoal" <?php echo ($usuario['departamento'] == 'Departamento Pessoal') ? 'selected' : ''; ?>>Departamento Pessoal</option>
                            <option value="Locação" <?php echo ($usuario['departamento'] == 'Locação') ? 'selected' : ''; ?>>Locação</option>
                            <option value="Logística" <?php echo ($usuario['departamento'] == 'Logística') ? 'selected' : ''; ?>>Logística</option>
                            <option value="Pasta" <?php echo ($usuario['departamento'] == 'Pasta') ? 'selected' : ''; ?>>Pasta</option>
                            <option value="Seguros" <?php echo ($usuario['departamento'] == 'Seguros') ? 'selected' : ''; ?>>Seguros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nivel" class="form-label">Nível</label>
                        <select class="form-select" id="nivel" name="nivel" required>
                            <option value="Usuario" <?php echo ($usuario['nivel'] == 'Usuario') ? 'selected' : ''; ?>>Usuário (Indicador)</option>
                            <option value="Captador" <?php echo ($usuario['nivel'] == 'Captador') ? 'selected' : ''; ?>>Captador</option>
                            <option value="Administrador" <?php echo ($usuario['nivel'] == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                    <!-- Checkbox removido -->
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$stmt->close();
$conn->close();
include 'footer.php';
?>
