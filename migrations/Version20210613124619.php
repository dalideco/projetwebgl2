<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210613124619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_recipes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_recipes (user_id INT NOT NULL, recipes_id INT NOT NULL, INDEX IDX_FB64FCBFA76ED395 (user_id), INDEX IDX_FB64FCBFFDF2B1FA (recipes_id), PRIMARY KEY(user_id, recipes_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_recipes ADD CONSTRAINT FK_FB64FCBFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_recipes ADD CONSTRAINT FK_FB64FCBFFDF2B1FA FOREIGN KEY (recipes_id) REFERENCES recipes (id) ON DELETE CASCADE');
    }
}