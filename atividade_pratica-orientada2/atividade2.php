<?php

// 1. A Classe Aluno (A mesma que criamos antes, versão resumida)
class Aluno {
    public function __construct(
        private string $nome,
        private float $nota
    ) {}

    public function getNome(): string {
        return $this->nome;
    }

    public function getNota(): float {
        return $this->nota;
    }
}

// 2. A Classe Turma (Gerenciador)
class Turma {
    // Array que guardará apenas objetos do tipo Aluno
    private array $alunos = [];

    // Método que exige obrigatoriamente um objeto da classe Aluno
    public function adicionarAluno(Aluno $aluno): void {
        $this->alunos[] = $aluno;
    }

    public function getAlunos(): array {
        return $this->alunos;
    }

    // Calcula a média usando os métodos da classe Aluno
    public function calcularMedia(): float {
        // Evita erro de divisão por zero se a turma estiver vazia
        if (count($this->alunos) === 0) {
            return 0.0;
        }

        $somaNotas = 0;
        foreach ($this->alunos as $aluno) {
            // O objeto turma chama o getNota() de cada objeto aluno
            $somaNotas += $aluno->getNota();
        }

        return $somaNotas / count($this->alunos);
    }
}

// =========================================================================
// TESTANDO AS CLASSES E A COMPOSIÇÃO
// =========================================================================

// Criamos a turma
$minhaTurma = new Turma();

// Criamos e adicionamos alunos
$minhaTurma->adicionarAluno(new Aluno("Ana Silva", 8.5));
$minhaTurma->adicionarAluno(new Aluno("Carlos Mendes", 5.0));
$minhaTurma->adicionarAluno(new Aluno("Beatriz Souza", 9.5));
$minhaTurma->adicionarAluno(new Aluno("Marcos Paulo", 7.0));

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 2 - Gerenciador de Turma</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .container { max-width: 500px; padding: 20px; background-color: white; border: 1px solid #ccc; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .media { margin-top: 20px; font-size: 1.2em; font-weight: bold; color: #28a745; }
    </style>
</head>
<body>

<div class="container">
    <h2>Gerenciador de Turma</h2>
    
    <table>
        <tr>
            <th>Nome do Aluno</th>
            <th>Nota</th>
        </tr>
        <?php foreach ($minhaTurma->getAlunos() as $aluno): ?>
            <tr>
                <!-- Como $aluno é um objeto, precisamos usar -> para chamar seus métodos -->
                <td><?php echo $aluno->getNome(); ?></td>
                <td><?php echo number_format($aluno->getNota(), 1, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="media">
        Média da Turma: <?php echo number_format($minhaTurma->calcularMedia(), 2, ',', '.'); ?>
    </div>
</div>

</body>
</html>