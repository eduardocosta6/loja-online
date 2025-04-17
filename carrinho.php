<?php
include 'db.php';
include 'templates/header.php';

if (!isset($_SESSION['user'])) {
    die("Precisa de fazer login para ver o carrinho.");
}

$id_user = $_SESSION['user']['id'];

if (isset($_GET['add'])) {
    $id_produto = $_GET['add'];
    $stmt = $pdo->prepare("SELECT * FROM carrinho WHERE id_utilizador = ? AND id_produto = ?");
    $stmt->execute([$id_user, $id_produto]);
    $item = $stmt->fetch();

    if ($item) {
        $stmt = $pdo->prepare("UPDATE carrinho SET quantidade = quantidade + 1 WHERE id = ?");
        $stmt->execute([$item['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO carrinho (id_utilizador, id_produto, quantidade) VALUES (?, ?, 1)");
        $stmt->execute([$id_user, $id_produto]);
    }
    header("Location: carrinho.php");
    exit;
}

if (isset($_GET['remove'])) {
    $id_produto = $_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM carrinho WHERE id_utilizador = ? AND id_produto = ?");
    $stmt->execute([$id_user, $id_produto]);
    header("Location: carrinho.php");
    exit;
}

$stmt = $pdo->prepare("SELECT p.id, p.nome, p.preco, c.quantidade FROM carrinho c JOIN produtos p ON c.id_produto = p.id WHERE c.id_utilizador = ?");
$stmt->execute([$id_user]);
?>

<div class="container">
    <h2>Carrinho de Compras</h2>
    
    <?php if ($stmt->rowCount() > 0): ?>
        <table>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Ações</th>
            </tr>
            <?php 
            $total = 0;
            while ($row = $stmt->fetch()): 
                $subtotal = $row['preco'] * $row['quantidade'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td><?php echo number_format($row['preco'], 2); ?>€</td>
                    <td><?php echo $row['quantidade']; ?></td>
                    <td><?php echo number_format($subtotal, 2); ?>€</td>
                    <td>
                        <a href="carrinho.php?remove=<?php echo $row['id']; ?>">Remover</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="2"><strong><?php echo number_format($total, 2); ?>€</strong></td>
            </tr>
        </table>

        <div style="margin-top: 20px; text-align: center;">
            <a href="index.php"><button>Continuar Comprando</button></a>
            <button>Finalizar Compra</button>
        </div>
    <?php else: ?>
        <div style="text-align: center; margin: 20px;">
            <p>O carrinho está vazio</p>
            <a href="index.php"><button>Voltar às Compras</button></a>
        </div>
    <?php endif; ?>
</div>


