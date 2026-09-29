<?php
// conexao.php
try {
    // Garante compatibilidade de caminho para qualquer servidor de deploy
    $dbPath = __DIR__ . '/database.sqlite';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar tabela de Provas
    $pdo->exec("CREATE TABLE IF NOT EXISTS provas (
        id TEXT PRIMARY KEY,
        titulo TEXT NOT NULL,
        duracao INTEGER NOT NULL,
        descricao TEXT,
        questoes TEXT NOT NULL
    )");

    // Criar tabela de Submissões de Alunos
    $pdo->exec("CREATE TABLE IF NOT EXISTS submissoes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        estudante_nome TEXT NOT NULL,
        estudante_ra TEXT NOT NULL,
        turma TEXT,
        exam_id TEXT,
        exam_titulo TEXT,
        nota REAL,
        respostas TEXT,
        criado_em TEXT
    )");

    // Inserir dados padrão caso o banco esteja vazio
    $stmt = $pdo->query("SELECT COUNT(*) FROM provas");
    if ($stmt->fetchColumn() == 0) {
        $defaultExams = [
            [
                "id" => "economia",
                "title" => "Economia Aplicada à Educação",
                "durationMinutes" => 15,
                "description" => "Avaliação de fundamentos micro e macroeconômicos, financiamento público do ensino, FUNDEB e retorno do capital humano.",
                "questions" => [
                    [
                        "id" => 1,
                        "type" => "multiple",
                        "text" => "De acordo com a teoria do Capital Humano (Schultz e Becker), qual é a principal premissa sobre o investimento em educação?",
                        "options" => [
                            "A educação é apenas um consumo cultural sem impacto direto na produtividade.",
                            "Os gastos em educação são investimentos que aumentam a produtividade individual e geram retornos econômicos sociais.",
                            "A educação reduz a eficiência econômica ao adiar a entrada dos jovens no mercado.",
                            "O investimento educacional deve ser exclusivamente mantido pela iniciativa privada."
                        ],
                        "correct" => 1
                    ],
                    [
                        "id" => 2,
                        "type" => "multiple",
                        "text" => "Qual o papel central do FUNDEB na estrutura de financiamento da educação básica no Brasil?",
                        "options" => [
                            "Financiar exclusivamente programas de pós-graduação no exterior.",
                            "Garantir a redistribuição equitativa de recursos para a educação básica com complementação financeira da União.",
                            "Subsidiar uniformes para escolas exclusivamente privadas.",
                            "Isentar impostos das corporações educacionais do terceiro setor."
                        ],
                        "correct" => 1
                    ],
                    [
                        "id" => 3,
                        "type" => "essay",
                        "text" => "Explique o conceito de 'Custo de Oportunidade' no contexto do abandono e da evasão escolar no ensino médio.",
                        "correctAnswerGuide" => "O aluno deve mencionar que a evasão traz ganhos imediatos baixos em troca de perdas salariais significativas no longo prazo."
                    ]
                ]
            ],
            [
                "id" => "pedagogia",
                "title" => "Pedagogia Hospitalar",
                "durationMinutes" => 15,
                "description" => "Exame sobre atendimento educacional hospitalar e domiciliário, humanização de cuidados e reintegração escolar.",
                "questions" => [
                    [
                        "id" => 1,
                        "type" => "multiple",
                        "text" => "A Pedagogia Hospitalar visa garantir a continuidade da aprendizagem da criança internada. Qual o objetivo principal da Classe Hospitalar?",
                        "options" => [
                            "Substituir o tratamento médico hospitalar por aulas de reforço.",
                            "Manter o vínculo do aluno com sua escolarização e promover o apoio psicoemocional durante a internação.",
                            "Isolar o aluno da família para focar nos livros didáticos.",
                            "Aplicar testes punitivos de nivelamento acadêmico."
                        ],
                        "correct" => 1
                    ],
                    [
                        "id" => 2,
                        "type" => "essay",
                        "text" => "Quais aspectos devem ser considerados pelo pedagogo ao flexibilizar o currículo escolar para um estudante hospitalizado?",
                        "correctAnswerGuide" => "Deve-se considerar a condição de saúde, fadiga, horários de medicação e estado emocional da criança."
                    ]
                ]
            ]
        ];

        foreach ($defaultExams as $ex) {
            $stmt = $pdo->prepare("INSERT INTO provas (id, titulo, duracao, descricao, questoes) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $ex['id'],
                $ex['title'],
                $ex['durationMinutes'],
                $ex['description'],
                json_encode($ex['questions'], JSON_UNESCAPED_UNICODE)
            ]);
        }
    }
} catch (PDOException $e) {
    // Retorna JSON limpo se houver falha de conexão na API
    if (basename($_SERVER['PHP_SELF']) === 'api.php') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["success" => false, "error" => "Erro na base de dados: " . $e->getMessage()]);
        exit;
    }
}