<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expires = new DateTime('now');
        $expires->add(new DateInterval('PT1H')); // 1 hour expiration
        $expires_str = $expires->format('Y-m-d H:i:s');

        $sql_update = "UPDATE usuarios SET reset_token = ?, reset_expires = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sss", $token, $expires_str, $email);
        $stmt_update->execute();

        header("Location: ../redefinir_senha.php?token=" . $token);
    } else {
        header("Location: ../esqueci_senha.php?msg=E-mail não encontrado.");
    }

    $stmt->close();
    $conn->close();
}
?>
