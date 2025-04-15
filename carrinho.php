<?php
// carrinho.php
// Página que mostra os produtos no carrinho do utilizador

include 'db.php';
include 'templates/header.php';

// Verificar se o utilizador está autenticado
if (!isset($_SESSION['user'])) {
    die("Precisa de fazer login para ver o carrinho.");
}

$id_user = $_SESSION['user']['id'];

// Adicionar produto ao carrinho
if (isset($_GET['add'])) {
    $id_produto = $_GET['add'];

    // Verificar se o produto já está no carrinho
    $stmt = $pdo->prepare("SELECT * FROM carrinho WHERE id_utilizador = ? AND id_produto = ?");
    $stmt->execute([$id_user, $id_produto]);
    $item = $stmt->fetch();

    if ($item) {
        // Já existe, atualizar quantidade
        $stmt = $pdo->prepare("UPDATE carrinho SET quantidade = quantidade + 1 WHERE id = ?");
        $stmt->execute([$item['id']]);
    } else {
        // Novo item no carrinho
        $stmt = $pdo->prepare("INSERT INTO carrinho (id_utilizador, id_produto, quantidade) VALUES (?, ?, 1)");
        $stmt->execute([$id_user, $id_produto]);
    }

    header("Location: carrinho.php");
    exit;
}

// Listar itens do carrinho
$stmt = $pdo->prepare("SELECT p.nome, p.preco, c.quantidade FROM carrinho c JOIN produtos p ON c.id_produto = p.id WHERE c.id_utilizador = ?");
$stmt->execute([$id_user]);

$total = 0;
while ($row = $stmt->fetch()) {
    $subtotal = $row['preco'] * $row['quantidade'];
    $total += $subtotal;
    echo "<p>{$row['nome']} ({$row['quantidade']}) - ".number_format($subtotal, 2)." €</p>";
}

echo "<h3>Total a pagar: ".number_format($total, 2)." €</h3>";

include 'templates/footer.php';




