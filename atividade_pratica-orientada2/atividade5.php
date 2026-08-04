<?php

// 1. A Interface (O Contrato)
// Define que qualquer gerador de relatório tem que ter o método gerar()
interface GeradorRelatorio {
    public function gerar(array $dados): string;
}

// 2. Implementação 1: Relatório em HTML
class RelatorioHTML implements GeradorRelatorio {
    public function gerar(array $dados): string {
        $html = "<ul>";
        foreach ($dados as $dado) {
            $html .= "<li>{$dado}</li>";
        }
        $html .= "</ul>";
        return "<div class='relatorio html'><strong>Relatório em formato HTML:</strong><br>{$html}</div>";
    }
}

// 3. Implementação 2: Simulador de PDF
class RelatorioPDF implements GeradorRelatorio {
    public function gerar(array $dados): string {
        // Apenas junta os nomes com um separador para simular um layout de texto corrido
        $texto = implode(" | ", $dados);
        return "<div class='relatorio pdf'><strong>Relatório em formato PDF:</strong><br>{$texto}</div>";
    }
}

// 4. A Classe Principal (Onde a mágica da Injeção de Dependência acontece!)
class SistemaAcademico {
    
    // INJEÇÃO DE DEPENDÊNCIA AQUI:
    // Nós não fazemos "$gerador = new RelatorioHTML()" aqui dentro.
    // Nós obrigamos quem for usar o SistemaAcademico a passar um gerador pronto!
    // E aceitamos QUALQUER gerador, desde que ele assine o contrato "GeradorRelatorio".
    public function __construct(
        private GeradorRelatorio $gerador
    ) {}

    public function exportarAlunos(array $alunos): string {
        // O sistema não sabe se é HTML ou PDF, ele só manda gerar!
        return $this->gerador->gerar($alunos);
    }
}

// =========================================================================
// TESTANDO A INJEÇÃO DE DEPENDÊNCIA
// =========================================================================

// Dados fictícios vindos do banco de dados
$listaDeAlunos = ["Ana Silva", "Carlos Mendes", "Beatriz Souza"];

// Teste 1: Injetando a dependência do relatório HTML
$sistemaComHTML = new SistemaAcademico(new RelatorioHTML());
$resultadoHTML = $sistemaComHTML->exportarAlunos($listaDeAlunos);

// Teste 2: Injetando a dependência do relatório PDF no mesmo sistema
$sistemaComPDF = new SistemaAcademico(new RelatorioPDF());
$resultadoPDF = $sistemaComPDF->exportarAlunos($listaDeAlunos);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade 5 - Injeção de Dependência</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #fdfdfd; }
        .container { max-width: 600px; margin: auto; }
        .relatorio { padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .html { background-color: #e3f2fd; border-left: 5px solid #2196f3; }
        .pdf { background-color: #ffebee; border-left: 5px solid #f44336; }
        ul { margin: 10px 0 0 0; }
    </style>
</head>
<body>

<div class="container">
    <h2>Sistema Acadêmico - Exportação</h2>
    <p>Veja como o mesmo sistema gera resultados diferentes dependendo da classe que foi "injetada" nele:</p>

    <!-- Exibe o resultado do HTML -->
    <?php echo $resultadoHTML; ?>

    <!-- Exibe o resultado do PDF -->
    <?php echo $resultadoPDF; ?>
</div>

</body>
</html>