<?php
declare(strict_types=1);

namespace App\Database;

class ConnectionProvider
{
    // Создаёт объект PDO, представляющий подключение к MySQL.
    public static function connectDatabase(): \PDO
    {
        $dsn = 'mysql:host=127.0.0.1;dbname=php_course';
        $user = 'php-course-app';
        $password = 'gX5t2UUbBn';
        return new \PDO($dsn, $user, $password);
    }
}
