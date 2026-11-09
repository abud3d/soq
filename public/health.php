<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
$ok=['php'=>PHP_VERSION,'pdo_mysql'=>extension_loaded('pdo_mysql'),'mbstring'=>extension_loaded('mbstring'),'fileinfo'=>extension_loaded('fileinfo'),'gd'=>extension_loaded('gd'),'webp'=>function_exists('imagewebp'),'vendor'=>is_file(dirname(__DIR__).'/vendor/autoload.php'),'geoip'=>is_readable((string)(getenv('GEOIP_DB')?:dirname(__DIR__).'/storage/geo/GeoLite2-City.mmdb'))];
$status=!in_array(false,$ok,true);http_response_code($status?200:503);echo json_encode(['ok'=>$status,'checks'=>$ok],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
