<?php
require_once __DIR__.'/../config.php';
if(empty($_SESSION['student']))response(['ok'=>false,'message'=>'Sessão da prova não encontrada.'],401);
$d=input_json();$answers=$d['answers']??[];
$c=exam_config();
if(count($answers)!==10)response(['ok'=>false,'message'=>'Respostas inválidas.'],422);

$now=time();$s=$_SESSION['student'];$score=0;
for($i=0;$i<10;$i++){
  if($answers[$i]!==null && (int)$answers[$i]===(int)$c['questions'][$i]['correct'])$score++;
}
$results=json_file(RESULTS_FILE,[]);
foreach($results as $r) if($r['student_code']===$s['code'])response(['ok'=>false,'message'=>'Esta prova já foi enviada.'],409);
$results[]=['name'=>$s['name'],'student_code'=>$s['code'],'score'=>$score,'total'=>10,
'grade'=>round($score,1),'finished_at'=>date('d/m/Y H:i:s')];
save_json(RESULTS_FILE,$results);
unset($_SESSION['student']);
response(['ok'=>true,'student'=>['name'=>$s['name']],'score'=>$score,'total'=>10,'grade'=>$score]);
