<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Online</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav>
        <a href="index.php">Produtos</a>
        <a href="carrinho.php">Carrinho</a>
        <?php if (isset($_SESSION['user'])): ?>
<?php if ($_SESSION['user']['tipo'] == 'admin'): ?>
        <a href="adicionar.php">Adicionar Produto</a>
        <a href="adicionar_utilizadores.php">Adicionar Utilizadores</a>
        <?php endif; ?>
        
        <a href="logout.php">Logout [<?php echo htmlspecialchars($_SESSION['user']['username']); ?>] </a>
        <?php else: ?>

            <a href="login.php">Login</a>
            <a href="registar.php">Registar</a>
            <?php endif; ?>
      </nav>
