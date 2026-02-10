<?php
session_start();
if (!isset($_SESSION['id']) || (($_SESSION['eh_captador'] ?? 0) == 1 && $_SESSION['nivel'] != 'Administrador')) {
    header("Location: home.php");
    exit();
}
include 'header.php';
?>

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

<?php include 'footer.php'; ?>
