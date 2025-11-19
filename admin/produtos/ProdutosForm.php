<?php
include '../header.php';
include '../db.class.php';

// CORRIGIDO — a tabela certa é "produtos"
$db = new DB('produtos');

$produto = null;
$msg = "";

// EDITAR
if (!empty($_GET['id'])) {
    $produto = $db->find($_GET['id']);
}

// SALVAR
if (!empty($_POST)) {

    $id = $_POST['id'] ?? null;

    $nome = trim($_POST['nome']);
    $preco = trim($_POST['preco']);
    $estoque = trim($_POST['estoque']);
    $tamanho = trim($_POST['tamanho']);
    $cor = trim($_POST['cor']);

    // Upload de imagem
    $imagem = $produto->imagem ?? '';

    if (!empty($_FILES['imagem']['name'])) {

        // cria nome único
        $nomeArquivo = time() . "_" . $_FILES['imagem']['name'];

        // move o arquivo para uploads
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $nomeArquivo);

        $imagem = $nomeArquivo;
    }

    // validação
    if (!$nome || !$preco || !$estoque) {
        $msg = "Preencha os campos obrigatórios: Nome, Preço e Estoque!";
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
    }
}
?>

<h2><?= empty($_GET['id']) ? "Cadastrar Produto" : "Editar Produto" ?></h2>

<p style="color: green; font-weight:bold;"><?= $msg ?></p>

<form method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $produto->id ?? '' ?>">

    <label>Nome:</label>
    <input type="text" class="form-control" name="nome"
           value="<?= $produto->nome ?? '' ?>" required>

    <label>Preço:</label>
    <input type="number" step="0.01" class="form-control" name="preco"
           value="<?= $produto->preco ?? '' ?>" required>

    <label>Estoque:</label>
    <input type="number" class="form-control" name="estoque"
           value="<?= $produto->estoque ?? '' ?>" required>

    <label>Tamanho:</label>
    <input type="text" class="form-control" name="tamanho"
           value="<?= $produto->tamanho ?? '' ?>">

    <label>Cor:</label>
    <input type="text" class="form-control" name="cor"
           value="<?= $produto->cor ?? '' ?>">

    <label>Imagem:</label>
    <input type="file" class="form-control" name="imagem">

    <?php if (!empty($produto->imagem)): ?>
        <br>
        <img src="../uploads/<?= $produto->imagem ?>" width="120">
    <?php endif; ?>

    <br>
    <button class="btn btn-success">Salvar</button>
</form>

<?php include '../footer.php'; ?>
