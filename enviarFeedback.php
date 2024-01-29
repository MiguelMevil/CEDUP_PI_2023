<?php
session_start();

if (!isset($_SESSION['email_user'])) {
    header('Location: index.php');
    session_destroy();
    exit();
}

include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_user = $_SESSION['email_user'];
    $feedback_text = $_POST['campoFeedback'];

    $query = "SELECT id_user FROM usuarios WHERE email_user = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param('s', $email_user);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_id) {
        $query = "INSERT INTO feedback (cod_user, txt_msg, data_msg, hora_msg) VALUES (?, ?, CURDATE(), CURTIME())";
        $stmt = $conexao->prepare($query);
        $stmt->bind_param('is', $user_id, $feedback_text);

        if ($stmt->execute()) {
            header("Location: feedback.php");
            exit();
        } else {
            echo "Erro: " . $stmt->error;
        }
    } else {
        header('Location: feedback.php');
        exit();
    }
} else {
    header('Location: feedback.php');
    exit();
}

$conexao->close();
?>