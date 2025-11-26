<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../../login.php');
    exit;
}

include '../db.class.php';
$db = new DB('usuario');

$busca = $_GET['busca'] ?? '';

$sql = "SELECT * FROM usuario";

if (!empty($busca)) {
    $sql .= " WHERE nome LIKE :busca 
              OR email LIKE :busca 
              OR login LIKE :busca 
              OR telefone LIKE :busca";
}

$sql .= " ORDER BY id DESC";

$stmt = $db->connect()->prepare($sql);

if (!empty($busca)) {
    $stmt->bindValue(':busca', "%$busca%");
}

$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = $db->connect()->prepare("DELETE FROM usuario WHERE id = ?");
    $delete->execute([$id]);

    header("Location: UsuarioList.php");
    exit;
}

include '../header.php';
?>

<h2 class="mt-3">Usuários</h2>

<form method="GET" class="mb-3">
    <input type="text" name="busca" class="form-control" placeholder="Buscar usuário..." value="<?= $busca ?>">
</form>

<a href="UsuarioForm.php" class="btn btn-primary mb-3">+ Novo Usuário</a>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Login</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($usuarios): ?>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u->id ?></td>
                    <td><?= htmlspecialchars($u->nome) ?></td>
                    <td><?= htmlspecialchars($u->email) ?></td>
                    <td><?= htmlspecialchars($u->login) ?></td>
                    <td><?= htmlspecialchars($u->telefone) ?></td>

                    <td>
                        <a href="UsuarioForm.php?id=<?= $u->id ?>" class="btn btn-warning btn-sm">Editar</a>

                        <a href="?delete=<?= $u->id ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Deseja realmente deletar?');">
                           Deletar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Nenhum usuário encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../footer.php'; ?>
