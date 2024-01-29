<?php
session_start();

if (!isset($_SESSION['email_adm'])) {
    header('Location: index.php');
    session_destroy();
    exit();
}

include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["campoID"];
    $nome = $_POST["campoNome"];
    $email = $_POST["campoEmail"];
    $telefone = $_POST["campoTelefone"];

    $sql = "UPDATE usuarios SET username = ?, email_user = ?, fone_user = ? WHERE id_user = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("sssi", $nome, $email, $telefone, $id);

    if ($stmt->execute()) {
        header("Location: pagina_adm.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conexao->close();
