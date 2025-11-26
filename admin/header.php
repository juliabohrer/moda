<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Moda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      :root {
        --rosa: #ff4d88;
        --preto: #111;
        --cinza-claro: #f8f3f7;
      }

      body { 
        background: var(--cinza-claro); 
        color: var(--preto); 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      .nav-custom { 
        background: white; 
        border-bottom: 4px solid var(--rosa); 
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      }

      .nav-custom .nav-link {
        color: var(--preto);
        font-weight: 500;
        margin-right: 10px;
        transition: 0.3s;
      }

      .nav-custom .nav-link:hover {
        color: var(--rosa);
      }

      .btn-logout {
        background: var(--rosa);
        color: white !important;
        border-radius: 6px;
        padding: 5px 12px;
        font-weight: bold;
        transition: 0.3s;
      }

      .btn-logout:hover {
        background: #e83e6b;
        color: white !important;
      }

      .navbar-brand img {
        height: 150px; 
      }

    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg nav-custom mb-4">
      <div class="container">
        <a class="navbar-brand" href="/Moda/home.php">
          <img src="/Moda/logo.png" alt="Rosé Closet">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav ms-auto align-items-lg-center">
            <?php if(!empty($_SESSION['user'])): ?>
              <li class="nav-item"><a class="nav-link" href="/Moda/admin/produtos/ProdutosList.php">Produtos</a></li>
              <li class="nav-item"><a class="nav-link" href="/Moda/admin/categoria/CategoriaList.php">Categorias</a></li>
              <li class="nav-item"><a class="nav-link" href="/Moda/admin/post/PostList.php">Posts</a></li>
              <li class="nav-item"><a class="nav-link" href="/Moda/admin/usuario/UsuarioList.php">Usuario</a></li>
              <li class="nav-item">
                <a class="btn btn-logout nav-link" href="/Moda/home.php">Sair</a>
              </li>
            <?php else: ?>
              <li class="nav-item"><a class="nav-link" href="/Moda/login.php">Login</a></li>
              <li class="nav-item"><a class="nav-link" href="/Moda/register.php">Registrar</a></li
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
