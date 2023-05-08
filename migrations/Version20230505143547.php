<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505143547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add image id to post';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
ALTER TABLE `post`
ADD image_id INT UNSIGNED DEFAULT NULL AFTER `image_path`,
ADD CONSTRAINT `post_image_FK_1`
    FOREIGN KEY (`image_id`)
    REFERENCES `image` (`id`)
    ON DELETE SET NULL
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE `post`
            DROP COLUMN `image_id`
        SQL);
    }
}
