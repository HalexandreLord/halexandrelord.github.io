<?php
require_once __DIR__.'/../config.php';
require_admin();
$d=input_json();$c=exam_config();
if(($d['type']??'')==='settings'){
  $title=trim((string)($d['title']??'Prova Online'));
  $duration=(int)($d['duration']??120);
  if($duration<1||$duration>600) response(['ok'=>false,'message'=>'Duração inválida.'],422);
  $c['title']=$title?:'Prova Online';$c['duration']=$duration;
}elseif(($d['type']??'')==='questions'){
  $qs=$d['questions']??[];
  if(count($qs)!==10) response(['ok'=>false,'message'=>'A prova deve possuir exatamente 10 questões.'],422);
  foreach($qs as $q){
    if(trim((string)($q['question']??''))===''||count($q['options']??[])!==5||!isset($q['correct'])||$q['correct']<0||$q['correct']>4)
      response(['ok'=>false,'message'=>'Cada questão precisa de enunciado, 5 alternativas e resposta correta.'],422);
    foreach($q['options'] as $o) if(trim((string)$o)==='') response(['ok'=>false,'message'=>'Nenhuma alternativa pode ficar vazia.'],422);
  }
  $c['questions']=$qs;
}else response(['ok'=>false,'message'=>'Operação inválida.'],400);
save_json(CONFIG_FILE,$c);response(['ok'=>true]);
