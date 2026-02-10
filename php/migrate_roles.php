<?php
include 'db.php';

// 1. Atualizar usuários que tinham a flag eh_captador para o Nível 'Captador'
$sql = "UPDATE usuarios SET nivel = 'Captador' WHERE eh_captador = 1 AND nivel != 'Administrador'";

if ($conn->query($sql) === TRUE) {
    echo "Usuários atualizados para o nível Captador com sucesso.<br>";
} else {
    echo "Erro ao atualizar usuários: " . $conn->error . "<br>";
}

$conn->close();
?>