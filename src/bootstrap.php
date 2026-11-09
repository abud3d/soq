<?php
declare(strict_types=1);

namespace Nshir;

use PDO;

final class App {
    private PDO $db;
    public function __construct() {
        $this->loadEnv(dirname(__DIR__) . '/.env');
        $this->db = new PDO((string)getenv('DB_DSN'), (string)getenv('DB_USER'), (string)getenv('DB_PASS'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_name('nshir_session');
            session_set_cookie_params(['httponly'=>true,'secure'=>isset($_SERVER['HTTPS']),'samesite'=>'Lax','path'=>'/']);
            session_start();
        }
    }
    private function loadEnv(string $file): void {
        if (!is_file($file)) return;
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            if ($line === '' || str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
            [$k,$v] = explode('=', $line, 2);
            if (getenv(trim($k)) === false) putenv(trim($k).'='.trim($v));
        }
    }
    public function db(): PDO { return $this->db; }
    public function user(): ?array {
        if (empty($_SESSION['uid'])) return null;
        $q=$this->db->prepare('SELECT id,email,name,country_id,city_id,area_id,email_verified_at FROM users WHERE id=? AND status="active"');
        $q->execute([(int)$_SESSION['uid']]);
        return $q->fetch() ?: null;
    }
    public function csrf(): string {
        return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
    }
    public function verifyCsrf(): void {
        if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['_token'] ?? ''))) {
            http_response_code(419); exit('انتهت صلاحية الطلب. أعد المحاولة.');
        }
    }
    public function clientIp(): string {
        return substr((string)($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
    }
    public function slug(string $value): string {
        $v=trim(preg_replace('/[^\p{Arabic}\p{L}\p{N}]+/u','-',mb_strtolower($value)) ?? 'ad','-');
        return $v !== '' ? mb_substr($v,0,90) : 'ad';
    }
}
