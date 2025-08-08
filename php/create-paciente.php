<?php
require_once 'db.php';
require_once 'authenticate.php';

// Obter todos os usuários para associar ao aluno
$stmt = $pdo->query("SELECT id, username FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $dataNascimento = $_POST['dataNascimento'];
    $tipoSanguineo = $_POST['tipoSanguineo'];
    $usuario_id = $_POST['usuario_id'];

    // Verificar se foi enviada uma imagem
    if (!empty($_FILES['imagem']['name'])) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $novoNome = uniqid() . '.' . $extensao;
        $caminho = __DIR__ . '/../storage/' . $novoNome;

        // Mover o arquivo para a pasta storage
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            // Inserir o caminho da imagem na tabela imagens
            $stmt = $pdo->prepare("INSERT INTO imagens (path) VALUES (?)");
            $stmt->execute([$novoNome]);
            $imagem_id = $pdo->lastInsertId();
        }
    } else {
        $imagem_id = null;
    }

    // Insere o novo aluno no banco de dados
    $stmt = $pdo->prepare("INSERT INTO pacientes (nome, data_nascimento, tipo_sanguineo , usuario_id, imagem_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $dataNascimento, $tipoSanguineo, $usuario_id, $imagem_id]);

    header('Location: index-paciente.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Paciente</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Adicionar Paciente</h1>
    </header>
    <main>
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="tipoSanguineo">Tipo Sanguíneo:</label>
            <input type="text" id="tipoSanguineo" name="tipoSanguineo" required>

            <label for="dataNascimento">Data de Nascimento:</label>
            <input type="date" id="dataNascimento" name="dataNascimento" required>

        
            <label for="usuario_id">Usuário:</label>
            <select id="usuario_id" name="usuario_id" required>
                <option value="">Selecione o usuário</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id'] ?>"><?= $usuario['username'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="imagem">Imagem de Perfil:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">

            <button type="submit">Adicionar</button>
        </form>
    </main>
</body>
</html>
