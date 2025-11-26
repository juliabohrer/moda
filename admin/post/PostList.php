<?php
include __DIR__ . '/../db.class.php';
include __DIR__ . '/../header.php';

$db = new DB('post');

$busca = $_GET['busca'] ?? '';
$where = "";

if (!empty($busca)) {
    $busca = trim($busca);
    $where = " WHERE titulo LIKE '%$busca%' OR autor LIKE '%$busca%' ";
}

if (!empty($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);

    try {
        $db->delete($id);
        echo "<div class='alert alert-success'>Post excluído com sucesso!</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Erro ao excluir: " . $e->getMessage() . "</div>";
    }
}

try {
    $sql = $db->connect()->query("SELECT * FROM post $where ORDER BY id DESC");
    $posts = $sql->fetchAll(PDO::FETCH_OBJ);
} catch (Exception $e) {
    echo "Erro ao buscar posts: " . $e->getMessage();
    exit;
}
?>

<h3 class="mb-4">Postagens</h3>

<a href="PostForm.php" class="btn btn-primary mb-3">+ Novo Post</a>

<form method="GET" class="mb-3">
    <input type="text" name="busca" class="form-control" placeholder="Buscar por título ou autor..." value="<?= $busca ?>">
</form>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Conteúdo</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($posts): ?>
            <?php foreach ($posts as $p): ?>
                <tr>
                    <td><?= $p->id ?></td>
                    <td><?= $p->titulo ?></td>
                    <td><?= $p->autor ?></td>
                    <td><?= mb_strimwidth($p->conteudo, 0, 200, "...") ?></td>

                    <td>
                        <?php if (!empty($p->imagem)): ?>
                            <img src="../uploadspost/<?= $p->imagem ?>" width="80" style="border-radius:5px;">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="PostForm.php?id=<?= $p->id ?>" class="btn btn-warning btn-sm">Editar</a>

                        <form action="" method="POST" style="display:inline-block;"
                              onsubmit="return confirm('Tem certeza que deseja excluir este post?');">
                            <input type="hidden" name="delete_id" value="<?= $p->id ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Nenhum post encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../footer.php'; ?>
