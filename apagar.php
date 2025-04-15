<?php
    include 'db.php';
    include 'templates/header.php';

    // Verificar se o utilizador é admin
    if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
        die("Acesso negado.Apenas os administradores podem apagar produtos.");
    }

    // Obter o ID do produto a apagar
    $id = $_GET['id'] ?? null;
    if (!$id){
        die("O ID do produto não existe.");
    }

    // Verificar se o produto existe
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();

    if (!$produto){
        die("Produto não encontrado.");
    }

    // Apagar o produto
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);

    // Redirecionar para a pagina principal
    header("location: index.php");
    exit;

