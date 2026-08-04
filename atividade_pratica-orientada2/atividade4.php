<?php

// 1. Criando a Trait (Pedaço de código reutilizável)
// Muito comum no Laravel para funcionalidades como logs, upload de arquivos, etc.
trait LogOperacao {
    public function registrarLog(string $acao): string {
        // Pega a data e hora atual
        $data = date('d/m/Y H:i:s');
        return "<div class='log-msg'>[{$data}] <strong>LOG do Sistema:</strong> {$acao}</div>";
    }
}

// 2. Criando a Classe Abstrata
abstract class Pessoa {
    // Usamos 'protected' em vez de 'private' para que as classes filhas 
    // (Aluno e Professor) consigam acessar essas variáveis.
    public function __construct(
        protected string $nome,
        protected string $email
    ) {}

    public function getDadosBase(): string {
        return "Nome: {$this->nome} | E-mail: {$this->email}";
    }

    // Método abstrato: Não tem corpo aqui. Obriga as classes filhas a criarem esse método!
    abstract public function obterPapel(): string;
}

// 3. Classe Aluno herdando de Pessoa e usando a Trait
class Aluno extends Pessoa {
    // Injetando a Trait nesta classe
    use LogOperacao;

    public function __construct(string $nome, string $email, private string $matricula) {
        // Chama o construtor da classe Pai (Pessoa) para preencher nome e email
        parent::__construct($nome, $email);
    }

    // Cumprindo a regra do método abstrato
    public function obterPapel(): string {
        return "Aluno (Matrícula: {$this->matricula})";
    }
}

// 4. Classe Professor herdando de Pessoa e usando a Trait
class Professor extends Pessoa {
    use LogOperacao;

    public function __construct(string $nome, string $email, private string $disciplina) {
        parent::__construct($nome, $email);
    }

    public function obterPapel(): string {
        return "Professor de {$this->disciplina}";
    }
}

// =========================================================================
// TESTANDO HERANÇA E TRAITS
// =========================================================================

// OBS: Se tentar fazer $p = new Pessoa("...", "..."); o PHP vai dar ERRO fatal!

$aluno = new Aluno("João Vitor", "joao@email.com", "20261001");
$professor = new Professor("Mariana Costa", "mariana@faculdade.com", "Banco de Dados");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 4 - Classe Abstrata e Trait</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f0f2f5; }
        .container { max-width: 600px; margin: auto; }
        .card { background-color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .badge { display: inline-block; padding: 5px 10px; background-color: #34495e; color: white; border-radius: 4px; font-size: 0.9em; margin-bottom: 15px; }
        .log-msg { background-color: #e8f8f5; color: #117a65; padding: 8px; border-left: 4px solid #1abc9c; font-size: 0.9em; margin-top: 10px; font-family: monospace; }
    </style>
</head>
<body>

<div class="container">
    <h2>Sistema de Gestão (Herança e Traits)</h2>

    <!-- Exibindo os dados do Aluno -->
    <div class="card">
        <span class="badge"><?php echo $aluno->obterPapel(); ?></span>
        <p><?php echo $aluno->getDadosBase(); ?></p>
        
        <!-- Chamando um método que veio "de brinde" pela Trait -->
        <?php echo $aluno->registrarLog("Aluno realizou login no portal."); ?>
    </div>

    <!-- Exibindo os dados do Professor -->
    <div class="card">
        <span class="badge"><?php echo $professor->obterPapel(); ?></span>
        <p><?php echo $professor->getDadosBase(); ?></p>
        
        <!-- A Trait funciona aqui também! -->
        <?php echo $professor->registrarLog("Professor lançou as notas da turma."); ?>
    </div>
</div>

</body>
</html>