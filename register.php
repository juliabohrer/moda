<?php
session_start();
require_once __DIR__ . '/admin/db.class.php';

$db = new DB('usuario'); 
$msg = '';

if(isset($_POST['register'])){

    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if($nome && $telefone && $email && $login && $senha){
        try {
            $sql = $db->connect()->prepare("
                INSERT INTO usuario (nome, telefone, email, login, senha)
                VALUES (?, ?, ?, ?, ?)
            ");

            $sql->execute([
                $nome,
                $telefone,
                $email,
                $login,
                $senha 
            ]);

            $msg = "Cadastro realizado com sucesso!";

        } catch(Exception $e){
            $msg = "Erro ao cadastrar: " . $e->getMessage();
        }

    } else {
        $msg = "Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro - Site Moda</title>
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
    width: 400px;
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

.success {
    background-color: #d4edda;
    color: #155724;
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
    <h2>Cadastro</h2>

    <?php if(!empty($msg)): ?>
        <div class="<?= strpos($msg, 'sucesso') !== false ? 'success' : 'alert' ?>"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

        <label>Login</label>
        <input type="text" name="login" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <button type="submit" name="register">Cadastrar</button>
    </form>

    <p><a href="login.php">Já tenho uma conta</a></p>
</div>

</body>
</html>
