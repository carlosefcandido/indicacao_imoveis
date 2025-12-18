<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['nivel'] != 'Administrador') {
    header("Location: ../index.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $departamento = $_POST['departamento'];
    $email = $_POST['email'];
    $nivel = $_POST['nivel'];

    $sql = "UPDATE usuarios SET nome = ?, departamento = ?, email = ?, nivel = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $departamento, $email, $nivel, $id);

    if ($stmt->execute()) {
        header("Location: ../listar_usuarios.php?msg=Usuário atualizado com sucesso!");
    } else {
        header("Location: ../listar_usuarios.php?msg=Erro ao atualizar usuário.");
    }

    $stmt->close();
    $conn->close();
}
?>
