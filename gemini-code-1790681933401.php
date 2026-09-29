<?php
// api.php
require_once 'conexao.php';
header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';

try {
    if ($action === 'get_data') {
        $provasStmt = $pdo->query("SELECT * FROM provas");
        $provasRows = $provasStmt->fetchAll(PDO::FETCH_ASSOC);
        $provas = [];
        foreach ($provasRows as $p) {
            $provas[$p['id']] = [
                "id" => $p['id'],
                "title" => $p['titulo'],
                "durationMinutes" => (int)$p['duracao'],
                "description" => $p['descricao'],
                "questions" => json_decode($p['questoes'], true)
            ];
        }

        $subsStmt = $pdo->query("SELECT * FROM submissoes ORDER BY id DESC");
        $subsRows = $subsStmt->fetchAll(PDO::FETCH_ASSOC);
        $subs = [];
        foreach ($subsRows as $s) {
            $subs[] = [
                "id" => (int)$s['id'],
                "studentName" => $s['estudante_nome'],
                "studentRa" => $s['estudante_ra'],
                "turma" => $s['turma'],
                "examId" => $s['exam_id'],
                "examTitle" => $s['exam_titulo'],
                "score" => (float)$s['nota'],
                "answers" => json_decode($s['respostas'], true),
                "timestamp" => $s['criado_em']
            ];
        }

        echo json_encode(["success" => true, "exams" => $provas, "submissions" => $subs]);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if ($action === 'save_exam') {
        $stmt = $pdo->prepare("INSERT OR REPLACE INTO provas (id, titulo, duracao, descricao, questoes) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $input['id'],
            $input['title'],
            $input['durationMinutes'],
            $input['description'],
            json_encode($input['questions'], JSON_UNESCAPED_UNICODE)
        ]);
        echo json_encode(["success" => true]);
        exit;
    }

    if ($action === 'delete_exam') {
        $stmt = $pdo->prepare("DELETE FROM provas WHERE id = ?");
        $stmt->execute([$input['id']]);
        echo json_encode(["success" => true]);
        exit;
    }

    if ($action === 'submit_exam') {
        $stmt = $pdo->prepare("INSERT INTO submissoes (estudante_nome, estudante_ra, turma, exam_id, exam_titulo, nota, respostas, criado_em) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $input['studentName'],
            $input['studentRa'],
            $input['turma'],
            $input['examId'],
            $input['examTitle'],
            $input['score'],
            json_encode($input['answers'], JSON_UNESCAPED_UNICODE),
            $input['timestamp']
        ]);
        echo json_encode(["success" => true]);
        exit;
    }

    if ($action === 'delete_submission') {
        $stmt = $pdo->prepare("DELETE FROM submissoes WHERE id = ?");
        $stmt->execute([$input['id']]);
        echo json_encode(["success" => true]);
        exit;
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}