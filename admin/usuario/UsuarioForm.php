<?php
// site/admin/usuario/UsuarioForm.php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit;
}
require_once __DIR__ . '/../db.class.php';
$db = new DB();

$edit = false;
$errors = [];

if (isset($_GET['id'])) {
    $edit = true;
    $id = (int)$_GET['id'];
    $stmt = $db->pdo->prepare("SELECT * FROM usuario WHERE id = :id");
    $stmt->execute(['id'=>$id]);
    $row = $stmt->fetch();
    if (!$row) { exit('Usuário não encontrado'); }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!$nome) $errors[] = "Nome obrigatório.";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email inválido.";
    if (!$login) $errors[] = "Login obrigatório.";

    // editar ou criar
    if (empty($errors)) {
        if ($edit) {
            // se senha preenchida, atualiza
            if ($senha) {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $db->pdo->prepare("UPDATE usuario SET nome_usuario=:nome, telefone=:telefone, email=:email, login=:login, senha=:senha WHERE id=:id");
                $stmt->execute(['nome'=>$nome,'telefone'=>$telefone,'email'=>$email,'login'=>$login,'senha'=>$hash,'id'=>$id]);
            } else {
                $stmt = $db->pdo->prepare("UPDATE usuario SET nome_usuario=:nome, telefone=:telefone, email=:email, login=:login WHERE id=:id");
                $stmt->execute(['nome'=>$nome,'telefone'=>$telefone,'email'=>$email,'login'=>$login,'id'=>$id]);
            }
            header('Location: UsuarioList.php');
            exit;
        } else {
            if (strlen($senha) < 6) $errors[] = "Senha mínimo 6 chars.";
            else {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $db->pdo->prepare("INSERT INTO usuario (nome_usuario, telefone, email, login, senha) VALUES (:nome,:telefone,:email,:login,:senha)");
                $stmt->execute(['nome'=>$nome,'telefone'=>$telefone,'email'=>$email,'login'=>$login,'senha'=>$hash]);
                header('Location: UsuarioList.php');
                exit;
            }
        }
    }
}

include __DIR__ . '/../../header.php';
?>
<div class="row">
  <div class="col-md-8">
    <h4><?= $edit ? 'Editar Usuário' : 'Novo Usuário' ?></h4>
    <?php if($errors): ?><div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div><?php endif; ?>
    <form method="post" novalidate>
      <div class="mb-3">
        <label>Nome</label>
        <input name="nome" class="form-control" value="<?= htmlspecialchars($row['nome_usuario'] ?? $_POST['nome'] ?? '') ?>" required>
      </div>
      <div class="mb-3">
        <label>Telefone</label>
        <input name="telefone" class="form-control" value="<?= htmlspecialchars($row['telefone'] ?? $_POST['telefone'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input name="email" type="email" class="form-control" value="<?= htmlspecialchars($row['email'] ?? $_POST['email'] ?? '') ?>" required>
      </div>
      <div class="mb-3">
        <label>Login</label>
        <input name="login" class="form-control" value="<?= htmlspecialchars($row['login'] ?? $_POST['login'] ?? '') ?>" required>
      </div>
      <div class="mb-3">
        <label>Senha <?= $edit ? '(preencha apenas para alterar)' : '' ?></label>
        <input name="senha" type="password" class="form-control">
      </div>
      <button class="btn btn-rosa"><?= $edit ? 'Atualizar' : 'Criar' ?></button>
      <a href="UsuarioList.php" class="btn btn-outline-secondary">Cancelar</a>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../../footer.php'; ?>
