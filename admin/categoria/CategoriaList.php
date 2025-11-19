<?php
require_once __DIR__ . '/../db.class.php';
$db = new DB('categoria');

// Busca
$termo = $_GET['busca'] ?? '';

// Query com busca
$sql = "SELECT * FROM categoria 
        WHERE nome LIKE :busca 
        ORDER BY id DESC";

$stmt = $db->connect()->prepare($sql);
$stmt->bindValue(':busca', "%$termo%");
$stmt->execute();

$categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

// Deletar
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

<form method="GET">
    <input type="text" name="busca" placeholder="Buscar categoria..." value="<?= $termo ?>">
    <button type="submit">Buscar</button>
</form>

<a href="CategoriaForm.php" class="btn btn-primary">Cadastrar Nova Categoria</a>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Cor</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($categorias as $c): ?>
            <tr>
                <td><?= $c->id ?></td>
                <td><?= $c->nome ?></td>
                <td><?= $c->descricao ?></td>
                <td><span style="background:<?= $c->cor ?>; padding:5px 15px; border-radius:5px;"></span></td>
                <td>
                    <a href="CategoriaForm.php?id=<?= $c->id ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="CategoriaList.php?delete=<?= $c->id ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Deseja realmente deletar?');">
                       Deletar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../footer.php'; ?>
