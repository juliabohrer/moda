<?php
require_once __DIR__ . '/../db.class.php';
include '../header.php';

$db = new DB('post');

$busca = $_GET['busca'] ?? '';
$where = "";

// FILTRO
if (!empty($busca)) {
    $where = " WHERE titulo LIKE '%$busca%' OR autor LIKE '%$busca%' ";
}

// BUSCA OS POSTS
try {
    $sql = $db->connect()->query("SELECT * FROM post $where ORDER BY id DESC");
    $posts = $sql->fetchAll(PDO::FETCH_OBJ);
} catch (Exception $e) {
    echo "Erro ao buscar posts: " . $e->getMessage();
    exit;
}
?>

<h3 class="mb-4">Lista de Posts</h3>

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

                    <td>
                        <?php if (!empty($p->imagem)): ?>
                            <img src="<?= $p->imagem ?>" width="70">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="PostForm.php?id=<?= $p->id ?>" class="btn btn-warning btn-sm">Editar</a>

                        <a href="PostDelete.php?id=<?= $p->id ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Deseja excluir este post?')">
                            Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="5">Nenhum post encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../footer.php'; ?>
