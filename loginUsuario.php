<?php
session_start();
include('conexao.php');

$email = trim($_POST['campoEmail']);
$senha = trim($_POST['campoSenha']);

$stmt = $conexao->prepare("SELECT id_user, senha_user FROM usuarios WHERE email_user = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id_user, $hash);
$stmt->fetch();
$stmt->close();

if ($hash !== null && password_verify($senha, $hash)) {
    $_SESSION['senhaIncorreta'] = false;
    $_SESSION['email_user'] = $email;
    $_SESSION['id_user'] = $id_user;
    header('location: perfil.php');
    exit();
}

$_SESSION['senhaIncorreta'] = true;
header('location: index.php');
exit();
?>
