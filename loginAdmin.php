<?php
session_start();
include('conexao.php');

$email = trim($_POST['campoEmail']);
$senha = trim($_POST['campoSenha']);

$stmt = $conexao->prepare("SELECT senha_adm FROM admin WHERE email_adm = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($hash);
$stmt->fetch();
$stmt->close();

if ($hash !== null && password_verify($senha, $hash)) {
    $_SESSION['senhaAdminIncorreta'] = false;
    $_SESSION['email_adm'] = $email;
    header('location: perfil_adm.php');
    exit();
}

$_SESSION['senhaAdminIncorreta'] = true;
header('location: login_adm.php');
exit();