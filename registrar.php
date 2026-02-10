<?php
session_start();
// Apenas administradores podem cadastrar novos usuários, ou usuários não logados.
if (isset($_SESSION['id']) && $_SESSION['nivel'] != 'Administrador') {
    header("Location: home.php");
    exit();
}

include 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2>Cadastro de Usuário</h2>
            </div>
            <div class="card-body">
                <?php if(isset($_GET['msg'])): ?>
                    <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
                <?php endif; ?>
                <form action="php/cadastrar_usuario.php" method="post">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="departamento" class="form-label">Departamento</label>
                        <select class="form-select" id="departamento" name="departamento" required>
                            <option value="Comercial">Comercial</option>
                            <option value="Condomínios">Condomínios</option>
                            <option value="Contabilidade">Contabilidade</option>
                            <option value="Contas a Pagar">Contas a Pagar</option>
                            <option value="Contas a Receber">Contas a Receber</option>
                            <option value="Departamento Pessoal">Departamento Pessoal</option>
                            <option value="Diretoria">Diretoria</option>
                            <option value="Fiscal">Fiscal</option>
                            <option value="Financeiro">Financeiro</option>
                            <option value="Gerência">Gerência</option>
                            <option value="Locação">Locação</option>
                            <option value="Logística">Logística</option>
                            <option value="Pasta">Pasta</option>
                            <option value="RH">RH</option>
                            <option value="Seguros">Seguros</option>
                            <option value="TI">TI</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <?php if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'Administrador'): ?>
                        <div class="mb-3">
                            <label for="nivel" class="form-label">Nível</label>
                            <select class="form-select" id="nivel" name="nivel" required>
                                <option value="Usuario">Usuário (Indicador)</option>
                                <option value="Captador">Captador</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                        <!-- Checkbox removido pois agora é um Nível -->
                    <?php else: ?>
                        <input type="hidden" name="nivel" value="Usuario">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
