<?php
require_once __DIR__ . '/../db.class.php';
$db = new DB('categoria');

$dados = null;
$msg = "";

// EDITAR
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = $db->connect()->prepare("SELECT * FROM categoria WHERE id = ?");
    $sql->execute([$id]);
    $dados = $sql->fetch(PDO::FETCH_OBJ);
}

// SALVAR
if (!empty($_POST)) {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $cor = trim($_POST['cor'] ?? '');

    if ($nome && $descricao && $cor) {

        // UPDATE
        if (!empty($_POST['id'])) {
            $sql = $db->connect()->prepare("
                UPDATE categoria
                SET nome = ?, descricao = ?, cor = ?
                WHERE id = ?
            ");

            $sql->execute([$nome, $descricao, $cor, $_POST['id']]);
            $msg = "Categoria atualizada com sucesso!";
        
        // INSERT
        } else {
            $sql = $db->connect()->prepare("
                INSERT INTO categoria (nome, descricao, cor)
                VALUES (?, ?, ?)
            ");

            $sql->execute([$nome, $descricao, $cor]);
            $msg = "Categoria cadastrada com sucesso!";
        }

    } else {
        $msg = "Preencha todos os campos!";
    }
}

include __DIR__ . '/../header.php';
?>

<h2><?= isset($dados) ? "Editar Categoria" : "Cadastrar Categoria" ?></h2>

<p style="color:green;"><?= $msg ?></p>

<form method="POST">
    
    <input type="hidden" name="id" value="<?= $dados->id ?? '' ?>">

    <label>Nome:</label>
    <input type="text" name="nome" value="<?= $dados->nome ?? '' ?>" required>

    <label>Descrição:</label>
    <input type="text" name="descricao" value="<?= $dados->descricao ?? '' ?>" required>

    <label>Cor (ex: #ff69b4):</label>
    <input type="text" name="cor" value="<?= $dados->cor ?? '' ?>" required>

    <button type="submit" class="btn btn-success mt-3">Salvar</button>
    <a href="CategoriaList.php" class="btn btn-secondary mt-3">Voltar</a>
</form>

<?php include __DIR__ . '/../footer.php'; ?>
