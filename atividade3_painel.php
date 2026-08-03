<?php


session_start();

// REGRA DE SEGURANCA: Se nao existir a sessao 'logado', expulsa o usuario
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    
    header("Location: atividade3.php");
    exit;
}


if (isset($_GET['sair'])) {
    
    session_destroy();
    
    header("Location: atividade3.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Restrito</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .painel { max-width: 500px; padding: 20px; background-color: white; border: 1px solid #ccc; border-radius: 8px; }
        .btn-sair { display: inline-block; padding: 10px 15px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>

<div class="painel">
    <h2>area Restrita</h2>
    <p>Bem-vindo, <strong><?php echo $_SESSION['nome_usuario']; ?></strong>!</p>
    <p>Voca conseguiu acessar esta pagina porque a sua sessao esta ativa.</p>
    <p>Tente copiar a URL desta pagina e abrir em uma aba anonima. Voce vera que o sistema bloqueara o acesso!</p>
    
    <br>
    <!-- O link passa um parametro 'sair' via GET na URL -->
    <a href="atividade3_painel.php?sair=true" class="btn-sair">Sair do Sistema (Logout)</a>
</div>

</body>
</html>