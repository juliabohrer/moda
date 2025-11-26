<?php
include '../db.class.php';
$db = new DB('produtos');

$busca = $_GET['busca'] ?? '';

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

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = $db->connect()->prepare("DELETE FROM produtos WHERE id = ?");
    $delete->execute([$id]);

    header("Location: ProdutosList.php");
    exit;
}

include '../header.php';
?>

<h2 class="mt-3">Produtos</h2>

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
                            <img src="../uploads/<?= $p->imagem ?>" width="70" class="img-thumbnail">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="ProdutosForm.php?id=<?= $p->id ?>" class="btn btn-warning btn-sm">Editar</a>

                        <a href="?delete=<?= $p->id ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Deseja realmente deletar?');">
                           Deletar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">Nenhum produto encontrado.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../footer.php'; ?>
