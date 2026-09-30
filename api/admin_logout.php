<?php
require_once __DIR__.'/../config.php';
unset($_SESSION['admin']);
response(['ok'=>true]);
