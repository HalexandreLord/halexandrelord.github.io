<?php
require_once __DIR__.'/../config.php';
require_admin();
$c=exam_config();
response(['ok'=>true,'settings'=>['title'=>$c['title'],'duration'=>$c['duration']],
'questions'=>$c['questions'],'results'=>json_file(RESULTS_FILE,[])]);
