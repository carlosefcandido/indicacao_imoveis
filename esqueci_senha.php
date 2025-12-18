<?php
include 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2>Recuperar Senha</h2>
            </div>
            <div class="card-body">
                <?php if(isset($_GET['msg'])): ?>
                    <div class="alert alert-info"><?php echo urldecode($_GET['msg']); ?></div>
                <?php endif; ?>
                <form action="php/solicitar_recuperacao.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Recuperar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
