<?php
require_once 'db.php';
require_once 'authenticate.php';

$id = $_GET['id'];

// Seleciona a consulta específica pelo ID
$stmt = $pdo->prepare("SELECT consultas.*, medicos.nome AS medico_nome, pacientes.nome AS paciente_nome FROM consultas LEFT JOIN medicos ON consultas.medico_id = medicos.id LEFT JOIN pacientes ON consultas.paciente_id = pacientes.id WHERE consultas.id = ?");
$stmt->execute([$id]);
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da consulta</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Detalhes da Consulta</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>pacientes: 
                        <a href="/php/create-paciente.php">Adicionar</a> | 
                        <a href="/php/index-paciente.php">Listar</a>
                    </li>
                    <li>Medicos: 
                        <a href="/php/create-professor.php">Adicionar</a> | 
                        <a href="/php/index-professor.php">Listar</a>
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
        <?php if ($consulta): ?>
            <p><strong>ID:</strong> <?= $consulta['id'] ?></p>
            <p><strong>Obs:</strong> <?= $consulta['observacao'] ?></p>
            <p><strong>Data e Hora:</strong> <?= $consulta['data_hora'] ?></p>
            <p><strong>Medico:</strong> <?= $consulta['medico_nome'] ?></p>
            <p><strong>Paciente:</strong> <?= $consulta['paciente_nome'] ?></p>
            <p>
                <a href="update-consulta.php?id=<?= $consulta['id'] ?>">Editar</a>
                <a href="delete-consulta.php?id=<?= $consulta['id'] ?>">Excluir</a>
            </p>
        <?php else: ?>
            <p>consulta não encontrada.</p>
        <?php endif; ?>
    </main>
</body>
</html>
