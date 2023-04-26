<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230423122342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates Post table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE post
(
  id INT UNSIGNED AUTO_INCREMENT,
  title VARCHAR(200),
  subtitle VARCHAR(200),
  content MEDIUMTEXT,
  posted_at DATETIME NOT NULL
    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE post");
    }
}
