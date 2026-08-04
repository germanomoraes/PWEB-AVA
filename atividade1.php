<?php
// Função para classificar a nota do aluno
function classificarAluno($nota) {
    // Validação básica da nota
    if (!is_numeric($nota) || $nota < 0 || $nota > 10) {
        return "Nota inválida. Por favor, insira um valor entre 0 e 10.";
    }

    // Estruturas condicionais para definir a situação
    if ($nota >= 7.0) {
        return "<strong style='color: green;'>Aprovado</strong>";
    } elseif ($nota >= 5.0) {
        return "<strong style='color: orange;'>Em Recuperação</strong>";
    } else {
        return "<strong style='color: red;'>Reprovado</strong>";
    }
}

$resultado = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta a nota enviada, garantindo que não esteja vazia
    $notaDigitada = str_replace(',', '.', $_POST['nota'] ?? ''); 
    $resultado = classificarAluno($notaDigitada);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 1 - Classificacao Academica</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        input, button { padding: 8px; margin-top: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Sistema de Classificacao</h2>
    
    <!-- O formulario envia os dados para a propria pagina via POST -->
    <form method="post" action="">
        <label for="nota">Digite a nota do aluno (0 a 10):</label><br>
        <input type="number" step="0.1" name="nota" id="nota" required>
        <button type="submit">Avaliar</button>
    </form>

    <?php if (!empty($resultado)): ?>
        <p>Situacao do Aluno: <?php echo $resultado; ?></p>
    <?php endif; ?>
</div>

</body>
</html>