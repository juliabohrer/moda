<?php
require_once __DIR__ . '/../db.class.php';
$db = new DB('produtos');

// Busca
$busca = $_GET['busca'] ?? '';

// Query com busca
$sql = "SELECT * FROM produtos";

if (!empty($busca)) {
    $sql .= " WHERE nome LIKE :busca";
}

$sql .= " ORDER BY id DESC";

$stmt = $db->connect()->prepare($sql);

if (!empty($busca)) {
    $stmt->bindValue(':busca', "%$busca%");
}

$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_OBJ);

// DELETE — igualzinho ao das categorias
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = $db->connect()->prepare("DELETE FROM produtos WHERE id = ?");
    $delete->execute([$id]);

    header("Location: ProdutosList.php");
    exit;
}

include __DIR__ . '/../header.php';
?>

<h2>Produtos</h2>

<form method="GET" class="mb-3">
    <input type="text" name="busca" class="form-control" placeholder="Buscar produto..." value="<?= $busca ?>">
</form>

<a href="ProdutosForm.php" class="btn btn-primary mb-3">+ Novo Produto</a>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($produtos): ?>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p->id ?></td>
                    <td><?= $p->nome ?></td>
                    <td>R$ <?= number_format($p->preco, 2, ',', '.') ?></td>
                    <td><?= $p->estoque ?></td>
                    <td>
                        <?php if (!empty($p->imagem)): ?>
                            <img src="../uploads/<?= $p->imagem ?>" width="60">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="ProdutosForm.php?id=<?= $p->id ?>" class="btn btn-warning btn-sm">Editar</a>

                        <a href="ProdutosList.php?delete=<?= $p->id ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Deseja realmente deletar este produto?');">
                           Deletar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Nenhum produto encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../footer.php'; ?>
