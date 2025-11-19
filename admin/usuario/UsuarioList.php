<?php
// site/admin/usuario/UsuarioList.php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit;
}
require_once __DIR__ . '/../db.class.php';
$db = new DB();

$q = trim($_GET['q'] ?? '');

$sql = "SELECT id, nome_usuario, telefone, email, login, criado_em FROM usuario WHERE 1";
$params = [];
if ($q) {
    $sql .= " AND (nome_usuario LIKE :q OR email LIKE :q OR login LIKE :q)";
    $params['q'] = "%$q%";
}
$sql .= " ORDER BY id DESC";
$stmt = $db->pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

include __DIR__ . '/../../header.php';
?>
<div class="row">
  <div class="col-md-12">
    <h4>Usuários</h4>
    <form class="row g-2 mb-3">
      <div class="col-auto">
        <input name="q" value="<?= htmlspecialchars($q) ?>" class="form-control" placeholder="Buscar nome, email ou login">
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-primary">Buscar</button>
        <a href="UsuarioForm.php" class="btn btn-rosa">Novo</a>
      </div>
    </form>
    <table class="table table-striped">
      <thead>
        <tr><th>Nome</th><th>Email</th><th>Login</th><th>Telefone</th><th>Criação</th><th>Ações</th></tr>
      </thead>
      <tbody>
        <?php foreach($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['nome_usuario']) ?></td>
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= htmlspecialchars($r['login']) ?></td>
          <td><?= htmlspecialchars($r['telefone']) ?></td>
          <td><?= htmlspecialchars($r['criado_em']) ?></td>
          <td>
            <a href="UsuarioForm.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-secondary">✎</a>
            <a href="UsuarioList.php?del=<?= $r['id'] ?>" onclick="return confirm('Excluir?')" class="btn btn-sm btn-outline-danger">🗑</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php
    // exclusão
    if (isset($_GET['del'])) {
        $did = (int)$_GET['del'];
        $stmt = $db->pdo->prepare("DELETE FROM usuario WHERE id = :id");
        $stmt->execute(['id'=>$did]);
        header('Location: UsuarioList.php');
        exit;
    }
    ?>
  </div>
</div>
<?php include __DIR__ . '/../../footer.php'; ?>
