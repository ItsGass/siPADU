<?php

declare(strict_types=1);

$root = dirname(__DIR__);

if (is_file($root.'/vendor/autoload.php')) {
    require $root.'/vendor/autoload.php';

    if (class_exists(Dotenv\Dotenv::class)) {
        Dotenv\Dotenv::createImmutable($root)->safeLoad();
    }
}

$readEnv = static function (string $key, string $default): string {
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

    if ($value === false || $value === null) {
        return $default;
    }

    return (string) $value;
};

$host = $readEnv('DB_HOST', '127.0.0.1');
$port = $readEnv('DB_PORT', '3306');
$username = $readEnv('DB_USERNAME', 'root');
$password = $readEnv('DB_PASSWORD', '');
$database = $argv[1] ?? $readEnv('DB_DATABASE', 'sipadu');

if (preg_match('/^[A-Za-z0-9_]+$/', $database) !== 1) {
    fwrite(STDERR, "[ERROR] Nama database tidak valid: {$database}\n");
    exit(1);
}

try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;port=%s;charset=utf8mb4', $host, $port),
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
    );

    $pdo->exec(sprintf(
        'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
        $database,
    ));

    echo "[OK] Database `{$database}` siap digunakan.\n";
} catch (PDOException $exception) {
    fwrite(STDERR, "[ERROR] Gagal membuat database.\n");
    fwrite(STDERR, "Pastikan Laragon sudah dibuka dan MySQL sudah berjalan (klik Start All).\n");
    fwrite(STDERR, 'Detail: '.$exception->getMessage()."\n");
    exit(1);
}
