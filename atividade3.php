<?php
// Toda pagina que usa sessoes no PHP precisa comecar com esta funcao
session_start();

// Verifica se o usuario ja esta logado e redireciona para o painel
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header("Location: atividade3_painel.php");
    exit;
}

$erro = "";

// Verifica se o formulario foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Simulando uma validacao (No mundo real, verificariamos no banco de dados)
    $usuario_correto = "aluno";
    $senha_correta = "123456";

    if ($usuario === $usuario_correto && $senha === $senha_correta) {
        // Login bem-sucedido! Criamos a sessao
        $_SESSION['logado'] = true;
        $_SESSION['nome_usuario'] = $usuario;
        
        // Redireciona o usuario para a pagina restrita
        header("Location: atividade3_painel.php");
        exit;
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 3 - Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 300px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        input, button { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; border: none; cursor: pointer; }
        .erro { color: red; margin-bottom: 10px; font-size: 0.9em; }
    </style>
</head>
<body>

<div class="container">
    <h2>Login do Sistema</h2>
    
    <?php if (!empty($erro)): ?>
        <div class="erro"><?php echo $erro; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" placeholder="Digite 'aluno'" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite '123456'" required>

        <button type="submit">Entrar</button>
    </form>
</div>

</body>
</html>