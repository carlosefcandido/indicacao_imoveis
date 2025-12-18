<?php
session_start();
include 'db.php';

$nome = $_POST['nome'];
$departamento = $_POST['departamento'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$nivel = isset($_POST['nivel']) ? $_POST['nivel'] : 'Usuario';

$sql = "INSERT INTO usuarios (nome, departamento, email, senha, nivel) VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nome, $departamento, $email, $senha, $nivel);

if ($stmt->execute()) {
    if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'Administrador') {
        header("Location: ../admin.php?msg=Usuário cadastrado com sucesso!");
    } else {
        header("Location: ../index.php?msg=Usuário cadastrado com sucesso! Faça o login.");
    }
} else {
    header("Location: ../registrar.php?msg=Erro ao cadastrar usuário.");
}

$stmt->close();
$conn->close();
?>