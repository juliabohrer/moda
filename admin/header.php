<?php
// site/header.php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Moda</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      :root {
        --rosa: #ff4d88;
        --preto: #111;
      }
      body { background:#f8f3f7; color:var(--preto); }
      .brand { color: white; background: linear-gradient(90deg,var(--rosa),#e83e6b); padding:10px 20px; border-radius:8px;}
      .nav-custom { background: white; border-bottom:4px solid var(--rosa); }
      .btn-rosa { background:var(--rosa); color:white; border:none; }
      .btn-rosa:hover { opacity:0.9; }
    </style>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg nav-custom mb-4">
    <div class="container">
      <a class="navbar-brand brand" href="/PWEB_1_TRABALHO/site/index.php">Rosé Closet</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <?php if(!empty($_SESSION['user'])): ?>
            <li class="nav-item"><a class="nav-link" href="/PWEB_1_TRABALHO/site/admin/dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="/PWEB_1_TRABALHO/site/admin/usuario/UsuarioList.php">Usuários</a></li>
            <li class="nav-item"><a class="nav-link" href="/PWEB_1_TRABALHO/site/admin/categoria/CategoriaList.php">Categorias</a></li>
            <li class="nav-item"><a class="nav-link" href="/PWEB_1_TRABALHO/site/admin/post/PostList.php">Posts</a></li>
            <li class="nav-item"><a class="nav-link" href="/PWEB_1_TRABALHO/site/index.php?logout=1">Sair</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/PWEB_1_TRABALHO/site/index.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="/PWEB_1_TRABALHO/site/register.php">Registrar</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
