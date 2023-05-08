<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505143546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add image table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE image
(
    id INT UNSIGNED AUTO_INCREMENT,
    path VARCHAR(200) NOT NULL,
    PRIMARY KEY (id)
)
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE image");
    }
}
