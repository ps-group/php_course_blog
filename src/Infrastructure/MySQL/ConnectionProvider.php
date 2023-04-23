<?php
declare(strict_types=1);

namespace App\Infrastructure\MySQL;

// TODO удалить при удалении PostTable
class ConnectionProvider
{
    public static function getConnection(): \PDO
    {
        return new \PDO('mysql:dbname=php_course;host=php-course-db', 'php-course-app', 'gX5t2UUbBn');
    }
}
