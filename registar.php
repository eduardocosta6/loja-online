<?php
    include 'db.php';
    include 'templates/header.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm'] ?? '';

        if ($password !== $confirm){
            echo "<p style='color: red;'>As palavras-passe não são iguais.</p>";
        } elseif (strlen($password) < 4){
            echo "<p style='color: red;'>A palavra-passe tem que ter mais de 4 carateres.</p>";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->fetch()){
                echo "<p style='color: red;'>O utilizador já existe!</p>";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO utilizadores (username, password, tipo) VALUES (?, ?, 'utilizador')");
                $stmt->execute([$username, $hash]);
                echo "<p>Registo efetuado com sucesso! Já pode fazer login <a href='login.php'>iniciar sessão</a></p>";
                exit;
            }
        }
    }
?>

<h2>Registar</h2>
<form method="post">
    <label for="username">Username: </label><br>
    <input type="text" name="username" required><br><br>

    <label for="password">Palavra-passe: </label><br>
    <input type="password" name="password" required><br><br>

    <label for="confirm">Confirmar Palavra-passe: </label><br>
    <input type="password" name="confirm" required><br><br>
    
    <button type="submit">Registar</button>
</form>
<?php include 'templates/footer.php'; ?>