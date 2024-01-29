<?php
session_start();
include('conexao.php');

$serial = trim($_POST['campoSerial']);

$stmt = $conexao->prepare("SELECT COUNT(*) AS TOTAL FROM estufa WHERE numero_serial = ?");
$stmt->bind_param("s", $serial);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

if ($total > 0) {
    $_SESSION['estufaExiste'] = true;
    header('location: consulta_estufa.php');
    exit();
} else {
    $id_user = $_SESSION['id_user'];
    $stmt = $conexao->prepare("INSERT INTO estufa (numero_serial, id_user) VALUES (?, ?)");
    $stmt->bind_param("si", $serial, $id_user);
    $stmt->execute();
    $stmt->close();
    
}

$_SESSION['cadastroEstufa'] = true;
header('location: consulta_estufa.php');
exit();
