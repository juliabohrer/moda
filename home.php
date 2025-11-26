<?php
session_start();

if (isset($_GET['sair'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['user'])) {
    header('Location: login.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Urban - Moda</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ffe4f1; 
            color: #000;
        }

        .topbar {
            background-color: #000;
            padding: 15px 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
            text-align: center;
        }

        h2 {
            margin-bottom: 30px;
            font-size: 28px;
            color: #d63384;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .btn {
            background-color: #ff7db8;
            padding: 15px 25px;
            border-radius: 10px;
            font-size: 18px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 3px 6px rgba(0,0,0,0.2);
        }

        .btn:hover {
            background-color: #ff4ca3;
            transform: scale(1.05);
        }

        .logout {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .logout:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="topbar">
        <h1>Painel Administrativo</h1>

        <a class="logout" href="?sair=1">Sair</a>
    </div>

    <div class="container">
        <h2>Bem-vindo ao Painel da Loja Urban</h2>
        <p style="font-size:18px; margin-bottom:35px;">
            Escolha uma das opções abaixo para gerenciar o site:
        </p>

        <div class="buttons">
            <a class="btn" href="admin/produtos/ProdutosList.php">Produtos</a>
            <a class="btn" href="admin/categoria/categoriaList.php">Categorias</a>
            <a class="btn" href="admin/post/postList.php">Posts</a>
            <a class="btn" href="admin/usuario/UsuarioList.php">Usuários</a>
        </div>
    </div>

</body>
</html>
