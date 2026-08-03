<?php
session_start();

// Proteção da página (Sessão)
if (!isset($_SESSION['logado_desafio']) || $_SESSION['logado_desafio'] !== true) {
    header("Location: atividade5.php");
    exit;
}

// Logoff
if (isset($_GET['sair'])) {
    session_destroy();
    header("Location: atividade5.php");
    exit;
}

// Inicializa o array de alunos na sessão se ele não existir
if (!isset($_SESSION['alunos'])) {
    $_SESSION['alunos'] = [];
}

$erros = [];
$sucesso = "";

// Processa o formulário de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_aluno = trim($_POST['nome_aluno'] ?? '');
    $curso = trim($_POST['curso'] ?? '');

    // Validação
    if (empty($nome_aluno) || strlen($nome_aluno) < 3) {
        $erros[] = "O nome deve ter pelo menos 3 caracteres.";
    }
    if (empty($curso)) {
        $erros[] = "Você deve informar um curso.";
    }

    // Se passou na validação, insere no "banco de dados" (Sessão)
    if (empty($erros)) {
        $_SESSION['alunos'][] = [
            'nome' => htmlspecialchars($nome_aluno),
            'curso' => htmlspecialchars($curso)
        ];
        $sucesso = "Aluno cadastrado com sucesso!";
    }
}

// Lógica para limpar a lista
if (isset($_GET['limpar'])) {
    $_SESSION['alunos'] = [];
    header("Location: atividade5_painel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Desafio Final - Painel</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #ecf0f1; margin: 40px; }
        .container { background-color: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ecf0f1; padding-bottom: 10px; margin-bottom: 20px; }
        .btn-sair, .btn-limpar { text-decoration: none; padding: 8px 12px; color: white; border-radius: 4px; font-size: 0.9em; }
        .btn-sair { background-color: #e74c3c; }
        .btn-limpar { background-color: #f39c12; }
        input, button { padding: 8px; width: 100%; box-sizing: border-box; margin-top: 5px; margin-bottom: 10px; }
        button { background-color: #2980b9; color: white; border: none; cursor: pointer; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #bdc3c7; padding: 10px; text-align: left; }
        th { background-color: #2980b9; color: white; }
        .alerta-erro { color: red; }
        .alerta-sucesso { color: green; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h3>Painel Administrativo</h3>
        <a href="atividade5_painel.php?sair=true" class="btn-sair">Sair</a>
    </div>

    <p>Bem-vindo(a), <strong><?php echo $_SESSION['usuario']; ?></strong>!</p>

    <!-- Formulário de Cadastro -->
    <h4>Cadastrar Novo Aluno</h4>
    
    <?php if (!empty($erros)): ?>
        <ul class="alerta-erro">
            <?php foreach($erros as $erro) echo "<li>$erro</li>"; ?>
        </ul>
    <?php endif; ?>
    
    <?php if ($sucesso) echo "<p class='alerta-sucesso'>$sucesso</p>"; ?>

    <form method="post" action="">
        <label>Nome do Aluno:</label>
        <input type="text" name="nome_aluno" required>

        <label>Curso:</label>
        <input type="text" name="curso" required>

        <button type="submit">Cadastrar</button>
    </form>

    <hr>

    <!-- Exibição dos Dados -->
    <h4>Alunos Cadastrados</h4>
    <?php if (count($_SESSION['alunos']) > 0): ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Curso</th>
            </tr>
            <?php foreach ($_SESSION['alunos'] as $aluno): ?>
                <tr>
                    <td><?php echo $aluno['nome']; ?></td>
                    <td><?php echo $aluno['curso']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <a href="atividade5_painel.php?limpar=true" class="btn-limpar">Limpar Todos os Registros</a>
    <?php else: ?>
        <p style="color: #7f8c8d;">Nenhum aluno cadastrado no momento.</p>
    <?php endif; ?>

</div>

</body>
</html>