<?php
session_start();
include __DIR__ . '/admin/db.class.php'; // conexão com o banco

$db = new DB('usuarios'); // tabela do banco
$erro = '';
$data = null;

if (!empty($_POST)) {
    try {
        $login = trim($_POST['login'] ?? '');
        $senha = trim($_POST['senha'] ?? '');

        $errors = [];

        if (empty($login)) {
            $errors[] = 'O login é obrigatório';
        }

        if (empty($senha)) {
            $errors[] = 'A senha é obrigatória';
        }

        if (empty($errors)) {
            $result = $db->login($_POST);

            if ($result !== 'error') {
                $_SESSION['usuario_id'] = $result->id;
                $_SESSION['login'] = $result->login;
                $_SESSION['nome'] = $result->nome;

                echo '<div class="alert">Login realizado com sucesso!</div>';
                echo "<script>
                    setTimeout(() => window.location.href = 'main.php', 2000);
                </script>";
            } else {
                $erro = 'Login ou senha incorretos!';
            }
        } else {
            $erro = implode('<br>', $errors);
        }
    } catch (Exception $e) {
        $erro = 'Ocorreu um erro: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login - Site Moda</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #fff0f5; /* rosa clarinho */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.form-box {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    width: 350px;
    text-align: center;
}

.form-box h2 {
    margin-bottom: 20px;
    color: #ff69b4; /* rosa */
}

.form-box label {
    display: block;
    margin-top: 15px;
    text-align: left;
    font-weight: bold;
    color: #333;
}

.form-box input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-sizing: border-box;
}

.form-box button {
    width: 100%;
    padding: 12px;
    margin-top: 20px;
    background-color: #ff69b4; /* rosa */
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
}

.form-box button:hover {
    background-color: #ff85c1;
}

.alert {
    background-color: #ffd1dc;
    color: #b0003a;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
}

.form-box p a {
    color: #ff69b4;
    text-decoration: none;
}

.form-box p a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

<div class="form-box">
    <h2>Login</h2>

    <?php if (!empty($erro)): ?>
        <div class="alert"><?= $erro ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <label>Login</label>
        <input type="text" name="login" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <button type="submit">Entrar</button>
    </form>

    <p><a href="UsuarioForm.php">Criar um novo usuário</a></p>
</div>

</body>
</html>
