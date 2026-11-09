<?php
declare(strict_types=1);
namespace Nshir;
require_once dirname(__DIR__).'/vendor/autoload.php';
use PDO;
final class App{
 private PDO $db;
 public function __construct(){$this->loadEnv(dirname(__DIR__).'/.env');$this->db=new PDO((string)getenv('DB_DSN'),(string)getenv('DB_USER'),(string)getenv('DB_PASS'),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);if(session_status()!==PHP_SESSION_ACTIVE){session_name('nshir_session');session_set_cookie_params(['httponly'=>true,'secure'=>(!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off'),'samesite'=>'Lax','path'=>'/']);session_start();}}
 private function loadEnv(string$file):void{if(!is_file($file))return;foreach(file($file,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES)?:[]as$line){if($line===''||str_starts_with(trim($line),'#')||!str_contains($line,'='))continue;[$k,$v]=explode('=',$line,2);if(getenv(trim($k))===false)putenv(trim($k).'='.trim($v));}}
 public function db():PDO{return$this->db;}
 public function user():?array{if(empty($_SESSION['uid']))return null;$q=$this->db->prepare('SELECT id,email,name,country_id,city_id,area_id,email_verified_at FROM users WHERE id=? AND status="active"');$q->execute([(int)$_SESSION['uid']]);return$q->fetch()?:null;}
 public function csrf():string{return$_SESSION['csrf']??=bin2hex(random_bytes(32));}
 public function verifyCsrf():void{if(!hash_equals((string)($_SESSION['csrf']??''),(string)($_POST['_token']??''))){http_response_code(419);exit('انتهت صلاحية الطلب. أعد المحاولة.');}}
 public function clientIp():string{return substr((string)($_SERVER['REMOTE_ADDR']??''),0,45);}
 public function rateLimit(string $action,int $max,int $seconds):void{$bucket=hash('sha256',$action.'|'.$this->clientIp());$q=$this->db->prepare('SELECT attempts,reset_at FROM auth_rate_limits WHERE bucket=?');$q->execute([$bucket]);$row=$q->fetch();$now=time();if(!$row||strtotime($row['reset_at'])<=$now){$until=date('Y-m-d H:i:s',$now+$seconds);$this->db->prepare('REPLACE INTO auth_rate_limits(bucket,attempts,reset_at) VALUES(?,1,?)')->execute([$bucket,$until]);return;}if((int)$row['attempts']>=$max){http_response_code(429);exit('محاولات كثيرة. حاول لاحقًا.');}$this->db->prepare('UPDATE auth_rate_limits SET attempts=attempts+1 WHERE bucket=?')->execute([$bucket]);}
 public function slug(string$value):string{$v=trim(preg_replace('/[^\p{Arabic}\p{L}\p{N}]+/u','-',mb_strtolower($value))??'ad','-');return$v!==''?mb_substr($v,0,90):'ad';}
}