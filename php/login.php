<?php
session_start();
include 'db.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT id, nome, email, senha, nivel, eh_captador FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($senha, $user['senha'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['nivel'] = $user['nivel'];
        // Removemos a dependência do eh_captador antigo, focando no Nível
        
        if ($user['nivel'] == 'Administrador') {
            header("Location: ../admin.php");
        } elseif ($user['nivel'] == 'Captador') {
            header("Location: ../captador.php");
        } else {
            header("Location: ../home.php");
        }
    } else {
        header("Location: ../index.php?msg=Senha incorreta.");
    }
} else {
    header("Location: ../index.php?msg=Usuário não encontrado.");
}

$stmt->close();
$conn->close();
?>