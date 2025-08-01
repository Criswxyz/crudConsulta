<?php
require_once 'db.php';
require_once 'authenticate.php';

$id = $_GET['id'];

// Seleciona a consulta específica pelo ID
$stmt = $pdo->prepare("SELECT * FROM consultas WHERE id = ?");
$stmt->execute([$id]);
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);

// Obter todos os medicos para associar à consulta
$stmt = $pdo->query("SELECT id, nome FROM medicos");
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_hora = $_POST['data_hora'];
    $observacao = $_POST['observacao'];
    $medico_id = $_POST['medico_id'];

    // Atualiza a consulta no banco de dados
    $stmt = $pdo->prepare("UPDATE consultas SET data_hora = ?, observacao = ?, medico_id = ? WHERE id = ?");
    $stmt->execute([$data_hora, $observacao, $medico_id, $id]);

    header('Location: read-consulta.php?id=' . $id);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar consulta</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Editar consulta</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>Alunos: 
                        <a href="/php/create-aluno.php">Adicionar</a> | 
                        <a href="/php/index-aluno.php">Listar</a>
                    </li>
                    <li>medicos: 
                        <a href="/php/create-medico.php">Adicionar</a> | 
                        <a href="/php/index-medico.php">Listar</a>
                    </li>
                    <li>consultas: 
                        <a href="/php/create-consulta.php">Adicionar</a> | 
                        <a href="/php/index-consulta.php">Listar</a>
                    </li>
                    <li><a href="/php/logout.php">Logout (<?= $_SESSION['username'] ?>)</a></li>
                <?php else: ?>
                    <li><a href="/php/user-login.php">Login</a></li>
                    <li><a href="/php/user-register.php">Registrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <form method="POST">
            <label for="data_hora">data_hora:</label>
            <input type="datetime-local" id="data_hora" name="data_hora" value="<?= $consulta['data_hora'] ?>" required>

            <label for="observacao">observacao:</label>
            <input type="text" id="observacao" name="observacao" value="<?= $consulta['observacao'] ?>" required>

            <label for="medico_id">medico:</label>
            <select id="medico_id" name="medico_id" required>
                <option value="">Selecione o medico</option>
                <?php foreach ($medicos as $medico): ?>
                    <option value="<?= $medico['id'] ?>" <?= $medico['id'] == $consulta['medico_id'] ? 'selected' : '' ?>>
                        <?= $medico['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Atualizar</button>
        </form>
    </main>
</body>
</html>
