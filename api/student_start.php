<?php
require_once __DIR__.'/../config.php';
$d=input_json();
$name=clean_student_name((string)($d['name']??''));$code=trim((string)($d['studentCode']??''));
if($name===''||$code==='')response(['ok'=>false,'message'=>'Informe nome e código do aluno.'],422);
$c=exam_config();
if(count($c['questions'])!==10)response(['ok'=>false,'message'=>'A prova ainda não está configurada.'],500);

$results=json_file(RESULTS_FILE,[]);
foreach($results as $r){
  if((string)$r['student_code']===$code) response(['ok'=>false,'message'=>'Este código de aluno já realizou a prova.'],409);
}
$_SESSION['student']=['name'=>$name,'code'=>$code,'started_at'=>time(),'end_at'=>time()+((int)$c['duration']*60)];
response(['ok'=>true,'student'=>['name'=>$name,'code'=>$code],
'questions'=>array_map(fn($q)=>['question'=>$q['question'],'options'=>$q['options']],$c['questions']),
'duration'=>(int)$c['duration'],'remainingSeconds'=>(int)$c['duration']*60]);
