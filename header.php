<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicação de Imóveis e Condomínios Acir Administradora</title>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#004085">
    <link rel="apple-touch-icon" href="imagens/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('sw.js')
                    .then(reg => console.log('Service Worker registrado!'))
                    .catch(err => console.log('Erro ao registrar SW', err));
            });
        }
    </script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-acir">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Acir Administradora</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['id'])): ?>
                        
                        <?php if ($_SESSION['nivel'] == 'Administrador'): ?>
                            <li class="nav-item"><a class="nav-link" href="admin.php">Indicações</a></li>
                            <li class="nav-item"><a class="nav-link" href="registrar.php">Cadastrar Usuário</a></li>
                            <li class="nav-item"><a class="nav-link" href="listar_usuarios.php">Listar Usuários</a></li>
                            <li class="nav-item"><a class="nav-link" href="home.php">Nova Indicação</a></li>
                            <li class="nav-item"><a class="nav-link" href="minhas_indicacoes.php">Minhas Indicações</a></li>
                        
                        <?php elseif ($_SESSION['nivel'] == 'Usuario'): ?>
                            <li class="nav-item"><a class="nav-link" href="home.php">Nova Indicação</a></li>
                            <li class="nav-item"><a class="nav-link" href="minhas_indicacoes.php">Minhas Indicações</a></li>
                        
                        <?php elseif ($_SESSION['nivel'] == 'Captador'): ?>
                             <!-- Captador vê apenas o painel dele (que é a index dele) e sair -->
                             <li class="nav-item"><a class="nav-link active" href="captador.php">Painel de Captação</a></li>
                        <?php endif; ?>
                        
                        <li class="nav-item"><a class="nav-link" href="php/logout.php">Sair</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="registrar.php">Registrar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="brand-bar">
        <div class="container-fluid py-3">
            <h1 class="brand-heading mb-0">Indicação de Imóveis e Condomínios<span class="brand-subtitle"></span></h1>
        </div>
    </div>
    <div class="container-fluid mt-4">
