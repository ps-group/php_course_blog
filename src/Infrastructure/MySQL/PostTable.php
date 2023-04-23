<?php
declare(strict_types=1);

namespace App\Infrastructure\MySQL;

use App\Entity\Post;

// TODO удалить, полностью заменив на PostRepository
class PostTable
{
    private const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    // Извлекает из БД данные поста с указанным ID.
    // Возвращает null, если пост не найден
    public function find(int $id): ?Post
    {
        $query = <<<SQL
        SELECT
            id,
            title,
            subtitle,
            content,
            posted_at
        FROM post
        WHERE id = $id
        SQL;

        $statement = $this->connection->query($query);
        if ($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            return $this->createPostFromRow($row);
        }

        return null;
    }

    // Сохраняет пост в таблицу post, возвращает ID поста.
    public function add(Post $post): int
    {
        throw new \RuntimeException('Not implemented');
    }

    public function delete(int $postId): void
    {
        $query = <<<SQL
        DELETE FROM post WHERE id = :post_id
        SQL;

        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':post_id' => $postId
        ]);
    }

    /**
     * @return Post[]
     */
    public function list(): array
    {
        $query = <<<SQL
        SELECT
            id,
            title,
            subtitle,
            content,
            posted_at
        FROM post
        SQL;

        $statement = $this->connection->query($query);

        $posts = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            $posts[] = $this->createPostFromRow($row);
        }

        return $posts;
    }

    private function createPostFromRow(array $row): Post
    {
        return new Post(
            (int)$row['id'],
            $row['title'],
            $row['subtitle'],
            $row['content'],
            $this->parseDateTime($row['posted_at'])
        );
    }

    private function parseDateTime(string $value): \DateTimeImmutable
    {
        $result = \DateTimeImmutable::createFromFormat(self::MYSQL_DATETIME_FORMAT, $value);
        if (!$result)
        {
            throw new \InvalidArgumentException("Invalid datetime value '$value'");
        }
        return $result;
    }
}
