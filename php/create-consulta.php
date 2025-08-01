<?php
require_once 'db.php';
require_once 'authenticate.php';

// Obter todos os medicoes para associar à consulta
$stmt = $pdo->query("SELECT id, nome FROM medicos");
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Obter todos os pacientes
$stmt = $pdo->query("SELECT id, nome FROM pacientes");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifique se todos os campos esperados existem antes de acessá-los
    if (
        !isset($_POST['data_hora'], $_POST['observacao'], $_POST['medico_id'], $_POST['paciente_id']) ||
        $_POST['paciente_id'] === "" ||
        $_POST['medico_id'] === ""
    ) {
        die('Erro: Selecione um médico e um paciente.');
    }

    $data_hora = $_POST['data_hora'];
    $observacao = $_POST['observacao'];
    $medico_id = $_POST['medico_id'];
    $paciente_id = $_POST['paciente_id'];

    

    // Insere a nova consulta no banco de dados
    $stmt = $pdo->prepare("INSERT INTO consultas (data_hora, observacao, medico_id, paciente_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data_hora, $observacao, $medico_id, $paciente_id]);

    header('Location: index-consulta.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar consulta</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Adicionar consulta</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>Pacientes: 
                        <a href="/php/create-paciente.php">Adicionar</a> | 
                        <a href="/php/index-paciente.php">Listar</a>
                    </li>
                    <li>Médico: 
                        <a href="/php/create-medico.php">Adicionar</a> | 
                        <a href="/php/index-medico.php">Listar</a>
                    </li>
                    <li>Consultas: 
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
            <label for="data_hora">Data e Hora:</label>
            <input type="datetime-local" id="data_hora" name="data_hora" required>

            <label for="observacao">Observações:</label>
            <input type="text" id="observacao" name="observacao" required>

            <label for="medico_id">medico:</label>
            <select id="medico_id" name="medico_id" required>
                <option value="">Selecione o medico</option>
                <?php foreach ($medicos as $medico): ?>
                    <option value="<?= $medico['id'] ?>"><?= $medico['nome'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="paciente_id">Paciente:</label>
            <select id="paciente_id" name="paciente_id" required>
                <option value="">Selecione o paciente</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id'] ?>"><?= $paciente['nome'] ?></option>
                <?php endforeach; ?>
            </select>


            <button type="submit">Adicionar</button>
        </form>
    </main>
</body>
</html>
