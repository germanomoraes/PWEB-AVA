<?php
session_start();

// Se já estiver logado, vai direto para o painel
if (isset($_SESSION['logado_desafio']) && $_SESSION['logado_desafio'] === true) {
    header("Location: atividade5_painel.php");
    exit;
}

$erro = "";
// Tenta buscar o cookie para preencher o usuário automaticamente
$usuario_salvo = $_COOKIE['lembrar_usuario'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    // Validação de login estática
    if ($usuario === "admin" && $senha === "1234") {
        
        // 1. Cria a sessão de login
        $_SESSION['logado_desafio'] = true;
        $_SESSION['usuario'] = $usuario;

        // 2. Cria o cookie para lembrar o nome na tela de login por 7 dias
        setcookie("lembrar_usuario", $usuario, time() + (7 * 24 * 60 * 60), "/");

        header("Location: atividade5_painel.php");
        exit;
    } else {
        $erro = "Credenciais inválidas! Use Usuário: admin / Senha: 1234";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Desafio Final - Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #2c3e50; color: white; display: flex; justify-content: center; padding-top: 50px; }
        .login-box { background-color: #34495e; padding: 30px; border-radius: 8px; width: 300px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        input, button { width: 100%; padding: 10px; margin-top: 8px; margin-bottom: 15px; border: none; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #27ae60; color: white; font-weight: bold; cursor: pointer; }
        .erro { background-color: #e74c3c; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>

<div class="login-box">
    <h2 style="text-align: center;">Acesso ao Sistema</h2>
    
    <?php if (!empty($erro)): ?>
        <div class="erro"><?php echo $erro; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <label for="usuario">Usuário:</label>
        <!-- Value usa o cookie caso ele exista -->
        <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($usuario_salvo); ?>" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>

        <button type="submit">Entrar</button>
    </form>
</div>

</body>
</html>