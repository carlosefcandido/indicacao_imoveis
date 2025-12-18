<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "SELECT id FROM usuarios WHERE reset_token = ? AND reset_expires > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_usuario = $row['id'];

        $sql_update = "UPDATE usuarios SET senha = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $senha, $id_usuario);
        $stmt_update->execute();

        header("Location: ../index.php?msg=Senha redefinida com sucesso! Faça o login.");
    } else {
        header("Location: ../index.php?msg=Token inválido ou expirado.");
    }

    $stmt->close();
    $conn->close();
}
?>
