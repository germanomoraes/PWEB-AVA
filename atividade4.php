<?php
// Lógica para "esquecer" o usuário (apagar o cookie)
if (isset($_GET['apagar'])) {
    // Para apagar um cookie, recriamos ele com um tempo de expiração no passado (ex: time() - 3600)
    setcookie("nome_visitante", "", time() - 3600, "/");
    header("Location: atividade4.php"); // Recarrega a página
    exit;
}

// Verifica se o formulário foi enviado via POST para salvar o nome
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['nome'])) {
    $nome = trim($_POST['nome']);
    
    // Matemática do tempo: time() é o agora. 
    // Somamos (7 dias * 24 horas * 60 minutos * 60 segundos)
    $tempo_expiracao = time() + (7 * 24 * 60 * 60);
    
    // Cria o cookie 'nome_visitante'. 
    // O "/" indica que o cookie vale para todo o site.
    setcookie("nome_visitante", $nome, $tempo_expiracao, "/");
    
    // Atualiza a página para o navegador reconhecer o novo cookie imediatamente
    header("Location: atividade4.php");
    exit;
}

// Variável para armazenar a mensagem que será exibida
$mensagem = "";
$tem_cookie = false;

// Verifica se o cookie já existe no navegador do usuário
if (isset($_COOKIE['nome_visitante'])) {
    $nome_salvo = htmlspecialchars($_COOKIE['nome_visitante']);
    $mensagem = "Bem-vindo de volta, <strong>$nome_salvo</strong>! Que bom ver você novamente. O sistema lembrará de você por 7 dias.";
    $tem_cookie = true;
} else {
    $mensagem = "Olá! Parece que é sua primeira vez aqui (ou seu cookie expirou).";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 4 - Controle com Cookies</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 450px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; }
        input, button { padding: 8px; margin-top: 10px; }
        button { background-color: #17a2b8; color: white; border: none; cursor: pointer; border-radius: 4px; }
        .btn-apagar { background-color: #dc3545; text-decoration: none; padding: 8px 12px; color: white; border-radius: 4px; display: inline-block; margin-top: 15px; font-size: 0.9em; }
        .mensagem-box { padding: 15px; background-color: #e9ecef; border-left: 4px solid #17a2b8; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Sistema de Boas-Vindas</h2>

    <div class="mensagem-box">
        <?php echo $mensagem; ?>
    </div>

    <!-- Se o cookie não existir, exibe o formulário -->
    <?php if (!$tem_cookie): ?>
        <form method="post" action="">
            <label for="nome">Como você gostaria de ser chamado?</label><br>
            <input type="text" name="nome" id="nome" required placeholder="Digite seu nome">
            <button type="submit">Salvar meu nome</button>
        </form>
    
    <!-- Se o cookie existir, exibe o botão de apagar -->
    <?php else: ?>
        <a href="atividade4.php?apagar=true" class="btn-apagar">Esquecer meu nome (Apagar Cookie)</a>
    <?php endif; ?>

</div>

</body>
</html>