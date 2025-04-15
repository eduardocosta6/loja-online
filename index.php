<?php
// Incluir o ficheiro db.php e header.php
include 'db.php';
include 'templates/header.php';

// Selecionar todos os produtos da BD
$stmt = $pdo->query("SELECT * FROM produtos");

echo "<div class='container'>";
// Apresentar os produtos na página
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<div class='cartao'><h2>{$row['nome']}</h2><p>{$row['descricao']}</p><p>{$row['preco']} €</p>";
    echo "<a href='carrinho.php?add={$row['id']}'>Comprar</a>";

    // Verificar se o utilizador é admin, mostrar opções de edição e remoção
    if (isset($_SESSION['user']) && $_SESSION['user']['tipo'] == 'admin') {
        echo " | <a href='atualizar.php?id={$row['id']}'>Editar</a> | <a href='apagar.php?id={$row['id']}'>Apagar</a>";
    }
    echo "</div>";
}
echo "</div>";

include 'templates/footer.php';
