<?php
session_start();

// Verificar se o admin está logado
if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php'); // Redirecionar para a página de login
    exit();
}
?>