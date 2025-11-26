<?php
session_start();
include __DIR__ . '/admin/db.class.php';

$db = new DB('usuario'); 
$erro = '';

if (!empty($_POST)) {

    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } else {
        $result = $db->login($login, $senha);

        if ($result) {
            $_SESSION['user'] = $result->login;
            $_SESSION['nome'] = $result->nome;
            $_SESSION['id'] = $result->id;

            header("Location: home.php");
            exit;
        } else {
            $erro = 'Login ou senha incorretos!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #fff0f5;
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
    color: #ff69b4;
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
    background-color: #ff69b4;
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
        <input type="text" name="login">

        <label>Senha</label>
        <input type="password" name="senha">

        <button type="submit">Entrar</button>
    </form>

    <p><a href="register.php">Criar nova conta</a></p>
</div>

</body>
</html>
