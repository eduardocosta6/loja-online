<?php
    include 'db.php';
    include 'templates/header.php';

    // Verificar se o utilizador é admin
    if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
        die("Acesso negado.Apenas os administradores podem editar produtos.");
    }

    // Verificar se o id do produto existe
    $id = $_GET['id'] ?? null;
    if (!$id){
        die("O ID do produto não existe.");
    }

    // Vamos buscar os dados do produto
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();

    if (!$produto){
        die("O produto não foi encontrado 😒");
    }

    // Se o formulario for submetido vamos atualizar o produto
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? '';

        if ($nome && $descricao && is_numeric($preco)){
            $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, descricao = ?, preco = ? WHERE id = ?");
            $stmt->execute([$nome, $descricao, $preco, $id]);
            echo "<p>Produto atualizado com sucesso 🙂</p>";
            echo "<p><a href='index.php'>Voltar a página principal 🔙</a></p>";
            exit;
        } else {
            echo "<p style='color: red;'>Preencha todos os campos do formulario corretamente 😒</p>";
        }
    }
?>

<h2>Atualizar Produto</h2>
<form method="post">
    <label for="nome">Nome: </label><br>
    <input type="text" name="nome" required value="<?php htmlspecialchars($produto['nome']); ?>" ><br><br>

    <label for="descricao">Descrição: </label><br>
    <textarea name="descricao" required value="?php htmlspecialchars($produto['descricao']); ?>"></textarea><br><br>

    <label for="preco">Preço (€): </label><br>
    <input type="text" name="preco" value="<?php htmlspecialchars($produto['preco']); ?>" required><br><br>

    <button type="submit">Atualizar Produto</button>
</form>

<?php include 'templates/footer.php' ?>