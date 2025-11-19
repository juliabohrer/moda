<?php
// site/index.php (login)
session_start();
require_once __DIR__ . '/admin/db.class.php';
$db = new DB();

if (isset($_GET['logout']) && $_GET['logout']==1) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!$login || !$senha) $errors[] = "Preencha login e senha.";

    if (empty($errors)) {
        $stmt = $db->pdo->prepare("SELECT * FROM usuario WHERE login = :login LIMIT 1");
        $stmt->execute(['login'=>$login]);
        $user = $stmt->fetch();
        if ($user && password_verify($senha, $user['senha'])) {
            // sucesso
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nome' => $user['nome_usuario'],
                'email' => $user['email']
            ];
            header('Location: admin/dashboard.php');
            exit;
        } else {
            $errors[] = "Login ou senha incorretos.";
        }
    }
}

include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-3">Entrar</h3>
        <?php if($errors): ?>
          <div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div>
        <?php endif; ?>
        <form method="post" novalidate>
          <div class="mb-3">
            <label class="form-label">Login</label>
            <input name="login" class="form-control" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input name="senha" type="password" class="form-control" required>
          </div>
          <button class="btn btn-rosa">Entrar</button>
          <a class="btn btn-outline-secondary" href="register.php">Registrar</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
