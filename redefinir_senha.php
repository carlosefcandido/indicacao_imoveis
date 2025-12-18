<?php
include 'header.php';
include 'php/db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT id FROM usuarios WHERE reset_token = ? AND reset_expires > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2>Redefinir Senha</h2>
            </div>
            <div class="card-body">
                <form action="php/atualizar_senha.php" method="post">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="mb-3">
                        <label for="senha" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Redefinir</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    } else {
        header("Location: index.php?msg=Token inválido ou expirado.");
    }
} else {
    header("Location: index.php");
}
?>

<?php include 'footer.php'; ?>
