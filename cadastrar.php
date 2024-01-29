<?php
session_start();
include('conexao.php');

$nome = trim($_POST['campoNome']);
$telefone = trim($_POST['campoTelefone']);
$email = trim($_POST['campoEmail']);
$senha = trim($_POST['campoSenha']);

$stmt = $conexao->prepare("SELECT COUNT(*) AS TOTAL FROM usuarios WHERE email_user = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

if ($total > 0) {
    $_SESSION['usuarioExiste'] = true;
    header('location: index.php');
    exit();
} else {
    $stmt = $conexao->prepare("INSERT INTO usuarios (username, fone_user, email_user, senha_user) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $telefone, $email, $hash);
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt->execute();
    $stmt->close();

    $id_user = $conexao->insert_id;
    $_SESSION['id_user'] = $id_user;
}

$_SESSION['cadastroUsuario'] = true;
$_SESSION['email_user'] = $email;
header('location: index.php');
exit();
?>
