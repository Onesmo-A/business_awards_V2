<?php

declare(strict_types=1);

function envValue(string $key, ?string $default = null): ?string
{
    $envPath = __DIR__ . '/../.env';
    if (!is_file($envPath)) {
        return $default;
    }

    $contents = file_get_contents($envPath);
    if ($contents === false) {
        return $default;
    }

    if (!preg_match('/^' . preg_quote($key, '/') . '=(.*)$/m', $contents, $matches)) {
        return $default;
    }

    $value = trim($matches[1]);
    $value = trim($value, "\"'");

    return $value === '' ? $default : $value;
}

$host = envValue('DB_HOST', '127.0.0.1');
$port = envValue('DB_PORT', '3306');
$db = envValue('DB_DATABASE', '');
$user = envValue('DB_USERNAME', 'root');
$pass = envValue('DB_PASSWORD', '');

$pdo = new PDO(
    "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4",
    $user,
    $pass,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

echo "SHOW CREATE TABLE migrations\n";
$stmt = $pdo->query('SHOW CREATE TABLE migrations');
print_r($stmt->fetchAll());

echo "\nSHOW COLUMNS FROM migrations\n";
$stmt = $pdo->query('SHOW COLUMNS FROM migrations');
print_r($stmt->fetchAll());

