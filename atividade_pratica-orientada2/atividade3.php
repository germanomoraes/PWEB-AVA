<?php

// 1. Criando a Interface (O Contrato)
interface Avaliavel {
    // Qualquer classe que implementar esta interface OBRIGATORIAMENTE
    // terá que criar um método chamado 'avaliar' que retorna uma string.
    public function avaliar(): string;
}

// 2. Classe Aluno implementando a Interface
class Aluno implements Avaliavel {
    public function __construct(private string $nome) {}

    public function getNome(): string {
        return $this->nome;
    }

    // Cumprindo o contrato da interface
    public function avaliar(): string {
        return "O aluno <strong>{$this->nome}</strong> está sendo avaliado por meio de provas e notas bimestrais.";
    }
}

// 3. Classe Professor implementando a mesma Interface
class Professor implements Avaliavel {
    public function __construct(
        private string $nome,
        private string $disciplina
    ) {}

    // Cumprindo o contrato da interface (mas de um jeito diferente do Aluno!)
    public function avaliar(): string {
        return "O professor <strong>{$this->nome}</strong> (Disciplina: {$this->disciplina}) está sendo avaliado pelo feedback dos alunos e coordenação.";
    }
}

// =========================================================================
// TESTANDO O POLIMORFISMO
// =========================================================================

// Vamos colocar objetos diferentes na mesma lista!
$pessoasParaAvaliar = [
    new Aluno("Lucas Pereira"),
    new Professor("Roberto Carlos", "Programação Web"),
    new Aluno("Mariana Silva")
];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 3 - Interfaces e Polimorfismo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f8f9fa; }
        .container { max-width: 600px; margin: auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .item { padding: 15px; border-bottom: 1px solid #eee; }
        .item:last-child { border-bottom: none; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.8em; color: white; margin-bottom: 5px; }
        .badge-aluno { background-color: #17a2b8; }
        .badge-professor { background-color: #6f42c1; }
    </style>
</head>
<body>

<div class="container">
    <h2>Sistema de Avaliação Institucional</h2>
    <p>Demonstrando o poder do Polimorfismo:</p>
    <hr>

    <?php 
    // MÁGICA DO POLIMORFISMO AQUI:
    // O loop (foreach) não faz ideia se $pessoa é um Aluno ou um Professor.
    // Ele só sabe que $pessoa assinou o contrato 'Avaliavel', 
    // então ele tem certeza absoluta de que pode chamar o método avaliar() sem dar erro!
    foreach ($pessoasParaAvaliar as $pessoa): 
    ?>
        <div class="item">
            <?php if ($pessoa instanceof Aluno): ?>
                <span class="badge badge-aluno">ALUNO</span>
            <?php elseif ($pessoa instanceof Professor): ?>
                <span class="badge badge-professor">PROFESSOR</span>
            <?php endif; ?>
            
            <p><?php echo $pessoa->avaliar(); ?></p>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>