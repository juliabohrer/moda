<?php
include '../header.php';
require_once __DIR__ . '/../db.class.php';

$db = new DB('categoria');

$categoria = null;
$msg = "";

if (!empty($_GET['id'])) {
    $categoria = $db->find($_GET['id']);
}

function valor($campo, $categoria) {
    return $_POST[$campo] ?? ($categoria->$campo ?? '');
}

if (!empty($_POST)) {

    $id = $_POST['id'] ?? null;

    $nome      = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $estacao   = trim($_POST['estacao']);

    if (!$nome || !$descricao || !$estacao) {
        $msg = "Preencha todos os campos!";
    } else {

        $dados = [
            "nome" => $nome,
            "descricao" => $descricao,
            "estacao" => $estacao
        ];

        if (empty($id)) {
            $db->insert($dados);
            $msg = "Categoria cadastrada!";
        } else {
            $db->update($id, $dados);
            $msg = "Categoria atualizada!";
        }

        $categoria = (object)$dados;
        $categoria->id = $id;
    }
}
?>

<h2 class="mt-3">
    <?= empty($_GET['id']) ? "Cadastrar Categoria" : "Editar Categoria" ?>
</h2>

<p style="color: green; font-weight:bold;"><?= $msg ?></p>

<form method="POST" class="mt-3">

    <input type="hidden" name="id" value="<?= $categoria->id ?? '' ?>">

    <label><strong>Coleção (Nome):</strong></label>
    <input type="text" class="form-control" name="nome" 
           value="<?= valor('nome', $categoria) ?>" required>

    <label class="mt-3"><strong>Descrição:</strong></label>
    <input type="text" class="form-control" name="descricao" 
           value="<?= valor('descricao', $categoria) ?>" required>

    <label class="mt-3"><strong>Estação:</strong></label>
    <select name="estacao" class="form-control" required>
        <option value="">Selecione...</option>

        <?php 
        $opcoes = ["Inverno", "Verão", "Outono", "Primavera"];
        foreach ($opcoes as $op): 
        ?>
            <option value="<?= $op ?>" 
                <?= (valor('estacao', $categoria) == $op) ? "selected" : "" ?>>
                <?= $op ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="row mt-4 mb-5">
        <div class="col-6">
            <button class="btn btn-success w-100">Salvar</button>
        </div>
        <div class="col-6">
            <a href="CategoriaList.php" class="btn btn-secondary w-100">Voltar</a>
        </div>
    </div>

</form>

<?php include '../footer.php'; ?>
