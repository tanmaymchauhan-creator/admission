<?php

define('DB_HOST', 'localhost');
define('DB_PORT', '3306'); 
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'student_admission_db');

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        // If the database does not exist (error 1049), auto-create and import schema
        if ($e->getCode() == 1049 || strpos($e->getMessage(), 'Unknown database') !== false) {
            $serverDsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
            $serverPdo = new PDO($serverDsn, DB_USER, DB_PASS, $options);
            $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

            $schemaFile = __DIR__ . '/../schema.sql';
            if (file_exists($schemaFile)) {
                $sql = file_get_contents($schemaFile);
                $pdo->exec($sql);
            }
        } else {
            throw $e;
        }
    }
} catch (PDOException $e) {
    die(
        '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 25px; border: 1px solid #f5c2c7; border-radius: 8px; background-color: #f8d7da; color: #842029;">' .
        '<h2 style="margin-top: 0;">Database Connection Failed</h2>' .
        '<p>Could not connect to MySQL server at <strong>' . htmlspecialchars(DB_HOST) . ':' . htmlspecialchars(DB_PORT) . '</strong>.</p>' .
        '<p>Please ensure that <strong>MySQL</strong> is started in your <strong>XAMPP Control Panel</strong>.</p>' .
        '<hr style="border: 0; border-top: 1px solid #f5c2c7; margin: 15px 0;">' .
        '<p style="font-size: 12px; margin-bottom: 0;">Error details: ' . htmlspecialchars($e->getMessage()) . '</p>' .
        '</div>'
    );
}

