<?php
    include 'db.php';
    include 'templates/header.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE username = ?");
        $stmt->execute([$username]); 
        $user = $stmt->fetch();

        // verificar se o username e password estão corretos
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'tipo' => $user['tipo']
            ];
            header("location: index.php");
            exit;
        } else {
            echo "<p style='color:red;'>Login inválido</p>";
        }
    }
?>

<h2>Login</h2>
<form method="post">
    <label>Utilizador: </label>
    <input type="text" name="username" required><br><br>
    <label>Password: </label>
    <input type="password" name="password" required><br><br>
    <button type="submit">Entrar</button>
</form>

<?php include 'templates/footer.php' ?>