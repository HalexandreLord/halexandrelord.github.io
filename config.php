<?php
declare(strict_types=1);
session_start();

const ADMIN_PASSWORD = 'TroqueEstaSenha123!'; // ALTERE antes de publicar.
const DATA_DIR = __DIR__ . '/data';
const CONFIG_FILE = DATA_DIR . '/config.json';
const RESULTS_FILE = DATA_DIR . '/results.json';

if (!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0755, true);

function json_file(string $file, $default) {
    if (!file_exists($file)) {
        file_put_contents($file, json_encode($default, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), LOCK_EX);
        return $default;
    }
    $raw = file_get_contents($file);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : $default;
}
function save_json(string $file, $data): void {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), LOCK_EX);
}
function input_json(): array {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}
function response(array $data, int $status=200): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function require_admin(): void {
    if (empty($_SESSION['admin'])) response(['ok'=>false,'message'=>'Acesso restrito.'],403);
}
function default_questions(): array {
    $qs=[];
    for($i=1;$i<=10;$i++){
        $qs[]=['question'=>"Digite aqui o enunciado da questão $i.",
               'options'=>['Alternativa A','Alternativa B','Alternativa C','Alternativa D','Alternativa E'],
               'correct'=>0];
    }
    return $qs;
}
function exam_config(): array {
    return json_file(CONFIG_FILE, ['title'=>'Prova Online','duration'=>120,'questions'=>default_questions()]);
}
function clean_student_name(string $s): string {
    $s=trim(preg_replace('/\s+/', ' ', $s));
    return mb_substr($s,0,120);
}
