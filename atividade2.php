<?php
// Inicializa variaveis para armazenar mensagens de erro e sucesso
$erros = [];
$dados_recebidos = [];

// Verifica se o formulario foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Captura os dados e remove espacos em branco no inicio e fim com trim()
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $idade = trim($_POST['idade'] ?? '');

    // Validacao do Nome (nao pode estar vazio)
    if (empty($nome)) {
        $erros[] = "O campo Nome e obrigatorio.";
    } elseif (strlen($nome) < 3) {
        $erros[] = "O Nome deve ter pelo menos 3 caracteres.";
    }

    // Validacao do E-mail (nno pode estar vazio e deve ter formato valido)
    if (empty($email)) {
        $erros[] = "O campo E-mail e obrigatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "Por favor, insira um endereco de e-mail valido.";
    }

    // Validacao da Idade (deve ser um nnmero inteiro positivo)
    if (empty($idade)) {
        $erros[] = "O campo Idade e obrigatorio.";
    } elseif (!filter_var($idade, FILTER_VALIDATE_INT) || $idade < 1) {
        $erros[] = "Por favor, insira uma idade valida.";
    }

    // Se nao houver erros, armazena os dados para exibicao
    if (empty($erros)) {
        $dados_recebidos = [
            'Nome' => htmlspecialchars($nome),
            'E-mail' => htmlspecialchars($email),
            'Idade' => htmlspecialchars($idade)
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 2 - Cadastro via Formulario</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .erro { color: red; margin-bottom: 10px; }
        .sucesso { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Cadastro de Usuario</h2>

    <!-- Exibe a lista de erros, se houver -->
    <?php if (!empty($erros)): ?>
        <div class="erro">
            <ul>
                <?php foreach ($erros as $erro): ?>
                    <li><?php echo $erro; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Formulario HTML -->
    <form method="post" action="">
        <div class="form-group">
            <label for="nome">Nome Completo:</label>
            <input type="text" name="nome" id="nome">
        </div>
        
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email">
        </div>

        <div class="form-group">
            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade">
        </div>

        <button type="submit">Cadastrar</button>
    </form>

    <!-- Exibe os dados formatados caso o cadastro seja bem-sucedido -->
    <?php if (!empty($dados_recebidos)): ?>
        <div class="sucesso">
            <h3>Cadastro realizado com sucesso!</h3>
            <p><strong>Nome:</strong> <?php echo $dados_recebidos['Nome']; ?></p>
            <p><strong>E-mail:</strong> <?php echo $dados_recebidos['E-mail']; ?></p>
            <p><strong>Idade:</strong> <?php echo $dados_recebidos['Idade']; ?> anos</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>