<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

include 'db.php';

$id_usuario = $_SESSION['id'];
$tipo = $_POST['tipo'];
$nome_proprietario = $_POST['nome_proprietario'];
$contato_proprietario = $_POST['contato_proprietario'];
$endereco_imovel = $_POST['endereco_imovel'];

$sql = "INSERT INTO imoveis (id_usuario, tipo, nome_proprietario, contato_proprietario, endereco_imovel) VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $id_usuario, $tipo, $nome_proprietario, $contato_proprietario, $endereco_imovel);

if ($stmt->execute()) {
    header("Location: ../minhas_indicacoes.php?msg=Imóvel indicado com sucesso!");
} else {
    header("Location: ../cadastrar_imovel.php?msg=Erro ao indicar imóvel.");
}

$stmt->close();
$conn->close();
?>