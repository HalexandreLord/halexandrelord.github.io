<?php
require_once __DIR__.'/../config.php';
$d=input_json();
$password=(string)($d['password']??'');
if(hash_equals(ADMIN_PASSWORD,$password)){session_regenerate_id(true);$_SESSION['admin']=true;response(['ok'=>true]);}
response(['ok'=>false,'message'=>'Senha incorreta.'],401);
