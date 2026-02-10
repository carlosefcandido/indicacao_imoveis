<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['nivel'] != 'Administrador' && $_SESSION['nivel'] != 'Captador')) {
    header("Location: ../index.php");
    exit();
}

include 'db.php';

$id_imovel = $_POST['id_imovel'];
$status = $_POST['status'];
$id_captador = !empty($_POST['id_captador']) ? $_POST['id_captador'] : NULL;
$observacao = !empty($_POST['observacao']) ? $_POST['observacao'] : NULL;

// Segurança: Apenas Administradores podem alterar a premiação paga
if ($_SESSION['nivel'] == 'Administrador') {
    $premiacao_paga = (isset($_POST['premiacao_paga']) && $_POST['premiacao_paga'] == "1") ? 1 : 0;
} else {
    // Se não for admin, mantém o valor atual do banco
    $sql_check = "SELECT premiacao_paga FROM imoveis WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id_imovel);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();
    $row_check = $res_check->fetch_assoc();
    $premiacao_paga = $row_check['premiacao_paga'];
    $stmt_check->close();
}

$sql = "UPDATE imoveis SET status = ?, id_captador = ?, premiacao_paga = ?, observacao = ? WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("siisi", $status, $id_captador, $premiacao_paga, $observacao, $id_imovel);

$redirect = "../admin.php";
if (isset($_POST['origem'])) {
    if ($_POST['origem'] == 'home') {
        $redirect = "../home.php";
    } elseif ($_POST['origem'] == 'captador') {
        $redirect = "../captador.php";
    }
}

if ($stmt->execute()) {
    header("Location: " . $redirect . "?msg=Atualizado com sucesso!");
} else {
    header("Location: " . $redirect . "?msg=Erro ao atualizar.");
}

$stmt->close();
$conn->close();
?>