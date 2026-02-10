<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SESSION['nivel'] == 'Administrador') {
        header("Location: admin.php");
    } elseif ($_SESSION['nivel'] == 'Captador') {
        header("Location: captador.php");
    } else {
        header("Location: home.php");
    }
    exit();
}
include 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <?php if(isset($_GET['msg'])): ?>
                    <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
                <?php endif; ?>
                <form action="php/login.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
            <div class="card-footer">
                <p>Não tem uma conta? <a href="registrar.php">Cadastre-se</a></p>
                <p><a href="esqueci_senha.php">Esqueci a senha</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2>Indique Imóveis/Condomínios e Ganhe!</h2>
            </div>
            <div class="card-body">
                <p>Agora ficou fácil indicar imóveis/condomínios e ser premiado. Confira como participar:</p>
                <h3>Como funciona</h3>
                <ol>
                    <li>Crie seu cadastro.</li>
                    <li>Na área de indicações, selecione “Cadastrar Indicação”.</li>
                    <li>Preencha os dados solicitados e finalize o cadastro.</li>
                </ol>
                <p>Pronto! Sua indicação será enviada com sucesso.</p>
                <p>Você poderá acompanhar o andamento acessando “Minhas Indicações”.</p>
                <h3>Bairros de Atuação</h3>
                <h4>Zona Sul e Centro</h4>
                <ul>
                    <li>Todos os bairros</li>
                </ul>
                <h4>Zona Oeste</h4>
                <ul>
                    <li>Barra da Tijuca</li>
                    <li>Recreio dos Bandeirantes</li>
                    <li>Jacarepaguá</li>
                </ul>
                <h4>Zona Norte</h4>
                <ul>
                    <li>Tijuca</li>
                    <li>Méier</li>
                    <li>Vila Isabel</li>
                    <li>Maracanã</li>
                    <li>Engenho Novo</li>
                    <li>Cachambi</li>
                    <li>Grajaú</li>
                    <li>Andaraí</li>
                </ul>
                <h4>Niterói</h4>
                <h4>Além dos locais citados acima, para condomínios também serão aceitas indicações para Duque de Caxias e Nova Iguaçu</h4>
                <p>Para indicações em outros bairros, será realizada uma análise prévia do imóvel/condomínio para verificar a possibilidade de atendimento.</p>
                <h3>Premiação</h3>
                <h4>Prazo de pagamento</h4>
                <p>A premiação será paga no mês seguinte à locação ou venda do imóvel indicado.</p>
                <h4>Valores</h4>
                <ul>
                    <li>Locação: 10% do valor do aluguel indicado</li>
                    <li>Venda: 2% do valor da corretagem da Acir</li>
                    <li>Condomínios: 50% do valor da primeira Taxa de Administração</li>
                </ul>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
