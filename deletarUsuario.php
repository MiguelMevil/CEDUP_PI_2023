<?php
session_start();

if (!isset($_SESSION['email_adm'])) {
    header('Location: index.php');
    session_destroy();
    exit();
}

include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "DELETE FROM usuarios WHERE id_user = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: pagina_adm.php");
            exit();
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ID inválido.";
    }
}

$conexao->close();
?>
