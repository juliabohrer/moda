<?php
include '../header.php';
require_once __DIR__ . '/../db.class.php';

$db = new DB('post');

$post = null;
$msg = "";

if (!empty($_GET['id'])) {
    $post = $db->find($_GET['id']);
}

function valor($campo, $post) {
    return $_POST[$campo] ?? ($post->$campo ?? '');
}

if (!empty($_POST)) {

    $id = $_POST['id'] ?? null;

    $titulo   = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);
    $autor    = trim($_POST['autor']);

    $imagem = $post->imagem ?? '';

    if (!empty($_FILES['imagem']['name'])) {

        $nomeArquivo = time() . "_" . $_FILES['imagem']['name'];
        $destino = "../uploadspost/" . $nomeArquivo;

        if (!is_dir("../uploadspost")) {
            mkdir("../uploadspost", 0777, true);
        }

        move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

        $imagem = $nomeArquivo;
    }

    if (!$titulo || !$conteudo || !$autor) {
        $msg = "Preencha Título, Conteúdo e Autor!";
    } else {

        $dados = [
            "titulo" => $titulo,
            "conteudo" => $conteudo,
            "imagem" => $imagem,
            "autor" => $autor
        ];

        if (empty($id)) {
            $db->insert($dados);
            $msg = "Post criado!";
        } else {
            $db->update($id, $dados);
            $msg = "Post atualizado!";
        }

        
        $post = (object)$dados;
        $post->id = $id;
    }
}
?>

<h2 class="mt-3">
    <?= empty($_GET['id']) ? "Criar Novo Post" : "Editar Post" ?>
</h2>

<p style="color: green; font-weight:bold;"><?= $msg ?></p>

<form method="POST" enctype="multipart/form-data" class="mt-3">

    <input type="hidden" name="id" value="<?= $post->id ?? '' ?>">

    <label><strong>Título:</strong></label>
    <input type="text" class="form-control" name="titulo" 
           value="<?= valor('titulo', $post) ?>" required>

    <label class="mt-3"><strong>Conteúdo:</strong></label>
    <textarea class="form-control" rows="5" name="conteudo" required><?= valor('conteudo', $post) ?></textarea>

    <label class="mt-3"><strong>Autor:</strong></label>
    <input type="text" class="form-control" name="autor" 
           value="<?= valor('autor', $post) ?>" required>

    <label class="mt-3"><strong>Imagem:</strong></label>
    <input type="file" class="form-control" name="imagem">

    <?php if (!empty($post->imagem)): ?>
        <div class="mt-3">
            <p>Imagem atual:</p>
            <img src="../uploadspost/<?= $post->imagem ?>" width="150" 
                 style="border-radius:8px; border:1px solid #ccc;">
        </div>
    <?php endif; ?>

    <div class="row mt-4 mb-5">
        <div class="col-6">
            <button class="btn btn-success w-100">Salvar</button>
        </div>
        <div class="col-6">
            <a href="PostList.php" class="btn btn-secondary w-100">Voltar</a>
        </div>
    </div>

</form>

<?php include '../footer.php'; ?>
