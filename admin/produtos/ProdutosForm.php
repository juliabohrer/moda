<?php
include '../header.php';
require_once '../db.class.php';

$db = new DB('produtos');

$produto = null;
$msg = "";

if (!empty($_GET['id'])) {
    $produto = $db->find($_GET['id']);
}

function valor($campo, $produto) {
    return $_POST[$campo] ?? ($produto->$campo ?? '');
}

if (!empty($_POST)) {

    $id = $_POST['id'] ?? null;

    $nome = trim($_POST['nome']);
    $preco = trim($_POST['preco']);
    $estoque = trim($_POST['estoque']);
    $tamanho = trim($_POST['tamanho']);
    $cor = trim($_POST['cor']);

    $imagem = $produto->imagem ?? '';

    if (!empty($_FILES['imagem']['name'])) {
        $nomeArquivo = time() . "_" . $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $nomeArquivo);
        $imagem = $nomeArquivo;
    }

    if (!$nome || !$preco || !$estoque) {
        $msg = "Preencha Nome, Preço e Estoque!";
    } else {

        $dados = [
            "nome" => $nome,
            "preco" => $preco,
            "estoque" => $estoque,
            "tamanho" => $tamanho,
            "cor" => $cor,
            "imagem" => $imagem
        ];

        if (empty($id)) {
            $db->insert($dados);
            $msg = "Produto cadastrado!";
        } else {
            $db->update($id, $dados);
            $msg = "Produto atualizado!";
        }

        $produto = (object)$dados;
        $produto->id = $id;
    }
}
?>

<h2 class="mt-3">
    <?= empty($_GET['id']) ? "Cadastrar Produto" : "Editar Produto" ?>
</h2>

<p style="color: green; font-weight:bold;"><?= $msg ?></p>

<form method="POST" enctype="multipart/form-data" class="mt-3">

    <input type="hidden" name="id" value="<?= $produto->id ?? '' ?>">

    <label>Nome:</label>
    <input type="text" class="form-control" name="nome" value="<?= valor('nome', $produto) ?>" required>

    <label class="mt-3">Preço:</label>
    <input type="number" step="0.01" class="form-control" name="preco"
           value="<?= valor('preco', $produto) ?>" required>

    <label class="mt-3">Estoque:</label>
    <input type="number" class="form-control" name="estoque"
           value="<?= valor('estoque', $produto) ?>" required>

    <label class="mt-3">Tamanho:</label>
    <input type="text" class="form-control" name="tamanho"
           value="<?= valor('tamanho', $produto) ?>">

    <label class="mt-3">Cor:</label>
    <input type="text" class="form-control" name="cor"
           value="<?= valor('cor', $produto) ?>">

    <label class="mt-3">Imagem:</label>
    <input type="file" class="form-control" name="imagem">

    <?php if (!empty($produto->imagem)): ?>
        <div class="mt-3">
            <p>Imagem atual:</p>
            <img src="../uploads/<?= $produto->imagem ?>" width="150" style="border-radius:8px; border:1px solid #ccc;">
        </div>
    <?php endif; ?>

    <div class="row mt-4 mb-5">
        <div class="col-6">
            <button class="btn btn-success w-100">Salvar</button>
        </div>
        <div class="col-6">
            <a href="ProdutosList.php" class="btn btn-secondary w-100">Voltar</a>
        </div>
    </div>

</form>

<?php include '../footer.php'; ?>
