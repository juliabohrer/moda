<?php
require_once __DIR__ . '/../db.class.php';
$db = new DB('categoria');

$termo = $_GET['busca'] ?? '';

$sql = "SELECT * FROM categoria 
        WHERE nome LIKE :busca 
        ORDER BY id DESC";

$stmt = $db->connect()->prepare($sql);
$stmt->bindValue(':busca', "%$termo%");
$stmt->execute();

$categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = $db->connect()->prepare("DELETE FROM categoria WHERE id = ?");
    $delete->execute([$id]);

    header("Location: CategoriaList.php");
    exit;
}

include __DIR__ . '/../header.php';
?>

<h2>Categorias</h2>

<form method="GET" class="mb-3">
    <input type="text" name="busca" placeholder="Buscar categoria..." 
           class="form-control" value="<?= $termo ?>">
</form>

<a href="CategoriaForm.php" class="btn btn-primary mb-3">Cadastrar Nova Categoria</a>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Coleção</th>
            <th>Descrição</th>
            <th>Estação</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($categorias as $c): ?>
            <tr>
                <td><?= $c->id ?></td>
                <td><?= $c->nome ?></td>
                <td><?= $c->descricao ?></td>
                <td><?= $c->estacao ?></td> 

                <td>
                    <a href="CategoriaForm.php?id=<?= $c->id ?>" 
                       class="btn btn-warning btn-sm">Editar</a>

                    <a href="CategoriaList.php?delete=<?= $c->id ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Deseja realmente deletar?');">
                       Deletar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../footer.php'; ?>
