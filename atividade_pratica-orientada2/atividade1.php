<?php

// Definição da Classe Aluno
class Aluno {
    
    // PHP 8: Constructor Property Promotion
    // Isso cria as variáveis $nome e $nota já de forma privada (Encapsulamento)
    public function __construct(
        private string $nome,
        private float $nota
    ) {}

    // Método Getter para acessar o nome (já que a propriedade é privada)
    public function getNome(): string {
        return $this->nome;
    }

    // Método Getter para acessar a nota
    public function getNota(): float {
        return $this->nota;
    }

    // Método Setter para alterar a nota com segurança
    public function setNota(float $novaNota): void {
        if ($novaNota >= 0 && $novaNota <= 10) {
            $this->nota = $novaNota;
        }
    }

    // Método que calcula a situação (Tipagem forte: obrigatoriamente retorna uma string)
    public function verificarSituacao(): string {
        if ($this->nota >= 7.0) {
            return "<strong style='color: green;'>Aprovado</strong>";
        } elseif ($this->nota >= 5.0) {
            return "<strong style='color: orange;'>Em Recuperação</strong>";
        } else {
            return "<strong style='color: red;'>Reprovado</strong>";
        }
    }
}

// =========================================================================
// TESTANDO A CLASSE NA PRÁTICA
// =========================================================================
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $nota = (float) str_replace(',', '.', $_POST['nota'] ?? 0);

    // Instanciando (criando) o objeto $aluno a partir da Classe Aluno
    $aluno = new Aluno($nome, $nota);

    // Usando os métodos do objeto para exibir o resultado
    $mensagem = "O aluno <strong>" . $aluno->getNome() . "</strong> obteve a nota " . $aluno->getNota() . " e está " . $aluno->verificarSituacao() . ".";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 1 - POO (Classe Aluno)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; }
        input, button { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2>Avaliação de Aluno (POO)</h2>
    
    <form method="post" action="">
        <label>Nome do Aluno:</label>
        <input type="text" name="nome" required>

        <label>Nota (0 a 10):</label>
        <input type="number" step="0.1" name="nota" required>

        <button type="submit">Avaliar</button>
    </form>

    <?php if (!empty($mensagem)): ?>
        <div style="margin-top: 20px; padding: 15px; border-left: 4px solid #007bff; background-color: #e9ecef;">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

