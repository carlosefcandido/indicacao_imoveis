<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['nivel'] != 'Administrador') {
    header("Location: ../index.php");
    exit();
}

include 'db.php';

$id_imovel = $_POST['id_imovel'];
$status = $_POST['status'];

$sql = "UPDATE imoveis SET status = ? WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id_imovel);

if ($stmt->execute()) {
    header("Location: ../admin.php?msg=Status atualizado com sucesso!");
} else {
    header("Location: ../admin.php?msg=Erro ao atualizar status.");
}

$stmt->close();
$conn->close();
?>