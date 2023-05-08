<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505143647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add author to post';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
ALTER TABLE `post`
ADD author INT UNSIGNED DEFAULT NULL AFTER `image_id`,
ADD CONSTRAINT `post_user_FK_1`
    FOREIGN KEY (`author`)
    REFERENCES `user` (`id`)
    ON DELETE SET NULL
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE `post` DROP COLUMN `author`
        SQL);
    }
}
