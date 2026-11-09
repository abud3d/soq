<?php
declare(strict_types=1);
$name=(string)($_GET['f']??'');
if(!preg_match('/^[a-f0-9]{40}\.webp$/',$name)){http_response_code(404);exit;}
$file=dirname(__DIR__,2).'/storage/uploads/'.$name;
if(!is_file($file)){http_response_code(404);exit;}
header('Content-Type: image/webp');header('Cache-Control: public,max-age=31536000,immutable');header('X-Content-Type-Options: nosniff');readfile($file);
