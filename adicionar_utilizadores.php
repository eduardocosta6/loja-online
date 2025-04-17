<?php
    include 'db.php';
    include 'templates/header.php';

    // Verificar se o utilizador é admin
    if (! isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
        die("Acesso negado.Apenas os administradores podem apagar produtos.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm'] ?? '';
        $tipo  = $_POST['tipo'] ?? '';

        if ($password !== $confirm) {
            echo "<p style='color: red;'>As palavras-passe não são iguais.</p>";
        } elseif (strlen($password) < 4) {
            echo "<p style='color: red;'>A palavra-passe tem que ter mais de 4 carateres.</p>";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->fetch()) {
                echo "<p style='color: red;'>O utilizador já existe!</p>";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO utilizadores (username, password, tipo) VALUES (?, ?, ?)");
                $stmt->execute([$username, $hash, $tipo]);
                echo "<p>Registo efetuado com sucesso! Já pode fazer login <a href='login.php'>iniciar sessão</a></p>";
                exit;
            }
        }
    }
?>

    <h2>Adicionar Utilizador</h2>
    <form method="post">
    <label for="username">Username: </label><br>
    <input type="text" name="username" required><br><br>

    <label for="password">Palavra-passe: </label><br>
    <input type="password" name="password" required><br><br>

    <label for="confirm">Confirmar Palavra-passe: </label><br>
    <input type="password" name="confirm" required><br><br>

    <label for="tipo">tipo de user </label><br>
    <select name="tipo" id="tipo">
    <option value="">--Escolha o tipo de utilizador--</option>
    <option value="admin">Admin</option>
    <option value="utilizador">User</option>
    </select>
    <br><br>

    <button type="submit">Adicionar utilizador</button>
    </form>
