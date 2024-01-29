<?php
session_start();

if (!isset($_SESSION['email_user'])) {
    header('Location: index.php');
    session_destroy();
    exit();
}

include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["campoNome"];
    $telefone = $_POST["campoTelefone"];
    $email = $_POST["campoEmail"];

    $sql = "UPDATE usuarios SET username = ?, fone_user = ? WHERE email_user = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("sss", $nome, $telefone, $email);

    if ($stmt->execute()) {
        header("Location: perfil.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conexao->close();