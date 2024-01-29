<?php
session_start();

if (!isset($_SESSION['email_adm'])) {
    header('Location: index.php');
    session_destroy();
    exit();
}

include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["campoNome"];
    $telefone = $_POST["campoTelefone"];
    $email = $_POST["campoEmail"];

    $sql = "UPDATE admin SET nome_adm = ?, fone_adm = ? WHERE email_adm = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("sss", $nome, $telefone, $email);

    if ($stmt->execute()) {
        header("Location: perfil_adm.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conexao->close();