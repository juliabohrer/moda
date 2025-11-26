<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../../login.php');
    exit;
}

include '../header.php';
include '/../db.class.php';

$db = new DB('usuario');

$usuario = null;
$msg = "";

if (!empty($_GET['id'])) {
    $usuario = $db->find($_GET['id']);
}

function valor($campo, $usuario) {
    return $_POST[$campo] ?? ($usuario->$campo ?? '');
}

if (!empty($_POST)) {

    $id = $_POST['id'] ?? null;

    $nome     = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $email    = trim($_POST['email']);
    $login    = trim($_POST['login']);
    $senha    = trim($_POST['senha']);

    if (!$nome || !$telefone || !$email || !$login) {
        $msg = "Preencha todos os campos obrigatórios!";
    } else {

        $dados = [
            "nome" => $nome,
            "telefone" => $telefone,
            "email" => $email,
            "login" => $login
        ];

        if (empty($id)) {

            if (!$senha) {
                $msg = "Digite uma senha para criar o usuário!";
            } else {
                $dados["senha"] = $senha;
                $db->insert($dados);

                header("Location: UsuarioList.php");
                exit;
            }

        } else {
            $db->update($id, $dados);

            if (!empty($senha)) {
                $db->update($id, ["senha" => $senha]);
            }

            header("Location: UsuarioList.php");
            exit;
        }

        $usuario = (object)$dados;
        $usuario->id = $id;
    }
}
?>

<h2 class="mt-3">
    <?= empty($_GET['id']) ? "Novo Usuário" : "Editar Usuário" ?>
</h2>

<p style="color:red; font-weight:bold;"><?= $msg ?></p>

<form method="POST" class="row g-3 mt-3">

    <input type="hidden" name="id" value="<?= $usuario->id ?? '' ?>">

    <div class="col-md-6">
        <label class="form-label"><strong>Nome</strong></label>
        <input type="text" name="nome" class="form-control"
               value="<?= valor('nome', $usuario) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label"><strong>Telefone</strong></label>
        <input type="text" name="telefone" class="form-control"
               value="<?= valor('telefone', $usuario) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label"><strong>Email</strong></label>
        <input type="email" name="email" class="form-control"
               value="<?= valor('email', $usuario) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label"><strong>Login</strong></label>
        <input type="text" name="login" class="form-control"
               value="<?= valor('login', $usuario) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">
            <strong>Senha <?= !empty($_GET['id']) ? "(opcional)" : "" ?></strong>
        </label>
        <input type="password" name="senha" class="form-control">
    </div>

    <div class="col-12 mt-4 mb-5">
        <button class="btn btn-success">Salvar</button>
        <a href="UsuarioList.php" class="btn btn-secondary">Voltar</a>
    </div>

</form>

<?php include '../footer.php'; ?>
