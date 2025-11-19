<?php
require_once __DIR__ . '/../db.class.php';
include '../header.php';

$db = new DB('post');

$id = $_GET['id'] ?? null;
$msg = "";

// DADOS INICIAIS
$post = [
    'titulo' => '',
    'conteudo' => '',
    'imagem' => '',
    'autor' => ''
];

// EDITAR → buscar dados
if ($id) {
    try {
        $sql = $db->connect()->prepare("SELECT * FROM post WHERE id = ?");
        $sql->execute([$id]);
        $post = $sql->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $msg = "Erro ao carregar post: " . $e->getMessage();
    }
}

// SALVAR
if (isset($_POST['salvar'])) {

    $titulo   = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);
    $autor    = trim($_POST['autor']);

    // Mantém imagem antiga caso não envie outra
    $nomeImagem = $post['imagem'];

    // UPLOAD DE IMAGEM
    if (!empty($_FILES['imagem']['name'])) {

        // Caminho correto para: site/admin/uploadspost/post/
        $uploadDir = __DIR__ . '/../uploadspost/post/';

        // Cria a pasta caso não exista
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);

        // Gera nome único
        $nomeImagem = time() . "_post." . $ext;

        // Caminho ABSOLUTO para mover o arquivo
        $destino = $uploadDir . $nomeImagem;

        // Faz upload
        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            $msg = "Erro ao enviar imagem!";
        }
    }

    // Validar campos
    if ($titulo && $conteudo && $autor) {
        try {
            if ($id) {
                // UPDATE
                $sql = $db->connect()->prepare("
                    UPDATE post SET 
                        titulo = ?, 
                        conteudo = ?, 
                        imagem = ?, 
                        autor = ?
                    WHERE id = ?
                ");

                $sql->execute([$titulo, $conteudo, $nomeImagem, $autor, $id]);
                $msg = "Post atualizado com sucesso!";

            } else {
                // INSERT
                $sql = $db->connect()->prepare("
                    INSERT INTO post (titulo, conteudo, imagem, autor)
                    VALUES (?, ?, ?, ?)
                ");

                $sql->execute([$titulo, $conteudo, $nomeImagem, $autor]);
                $msg = "Post criado com sucesso!";
            }
        } catch (Exception $e) {
            $msg = "Erro ao salvar: " . $e->getMessage();
        }
    } else {
        $msg = "Preencha todos os campos!";
    }
}
?>

<div class="card mt-4" style="max-width: 650px; margin:auto;">
    <div class="card-body">

        <h3 class="text-center mb-4">
            <?= $id ? "Editar Post" : "Novo Post" ?>
        </h3>

        <?php if ($msg): ?>
            <div class="alert alert-info"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label class="mt-2"><strong>Título:</strong></label>
            <input type="text" name="titulo" class="form-control" 
                   value="<?= $post['titulo'] ?>" required>

            <label class="mt-3"><strong>Conteúdo:</strong></label>
            <textarea name="conteudo" class="form-control" rows="5" required><?= $post['conteudo'] ?></textarea>

            <label class="mt-3"><strong>Imagem:</strong></label>
            <input type="file" name="imagem" class="form-control">

            <?php if (!empty($post['imagem'])): ?>
                <div class="mt-2">
                    <img src="../uploadspost/post/<?= $post['imagem'] ?>" width="150" style="border-radius:5px;">
                </div>
            <?php endif; ?>

            <label class="mt-3"><strong>Autor:</strong></label>
            <input type="text" name="autor" class="form-control" value="<?= $post['autor'] ?>" required>

            <button type="submit" name="salvar" class="btn btn-success mt-4 w-100">
                Salvar
            </button>

        </form>

        <a href="PostList.php" class="btn btn-secondary mt-3 w-100">Voltar</a>

    </div>
</div>

<?php include '../footer.php'; ?>
