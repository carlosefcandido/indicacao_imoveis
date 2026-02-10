<?php
include 'db.php';

//$sql = "ALTER TABLE imoveis ADD COLUMN id_captador INT NULL AFTER status, ADD COLUMN premiacao_paga TINYINT(1) DEFAULT 0 AFTER id_captador";

//if ($conn->query($sql) === TRUE) {
//    echo "Table imoveis updated successfully<br>";
//} else {
//    echo "Error updating table imoveis: " . $conn->error . "<br>";
//}

//$sql_user = "ALTER TABLE usuarios ADD COLUMN eh_captador TINYINT(1) DEFAULT 0 AFTER nivel";
//if ($conn->query($sql_user) === TRUE) {
 //   echo "Table usuarios updated successfully<br>";
//} else {
//    echo "Error updating table usuarios: " . $conn->error . "<br>";
//}

$sql_obs = "ALTER TABLE imoveis ADD COLUMN observacao TEXT NULL AFTER premiacao_paga";
if ($conn->query($sql_obs) === TRUE) {
    echo "Column 'observacao' added to imoveis successfully<br>";
} else {
    echo "Error adding column 'observacao': " . $conn->error . "<br>";
}

$conn->close();
?>
