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

    // Insere o novo aluno no banco de dados
    $stmt = $pdo->prepare("INSERT INTO pacientes (nome, data_nascimento, tipo_sanguineo , usuario_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $dataNascimento, $tipoSanguineo, $usuario_id]);

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

            <button type="submit">Adicionar</button>
        </form>
    </main>
</body>
</html>
