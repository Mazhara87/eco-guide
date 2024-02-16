<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131092652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_type (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum_comment DROP FOREIGN KEY FK_65B81F1D4B89032C');
        $this->addSql('ALTER TABLE forum_comment DROP FOREIGN KEY FK_65B81F1DA76ED395');
        $this->addSql('DROP INDEX IDX_65B81F1D4B89032C ON forum_comment');
        $this->addSql('DROP INDEX IDX_65B81F1DA76ED395 ON forum_comment');
        $this->addSql('ALTER TABLE forum_comment DROP post_id, DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE post_type');
        $this->addSql('ALTER TABLE forum_comment ADD post_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE forum_comment ADD CONSTRAINT FK_65B81F1D4B89032C FOREIGN KEY (post_id) REFERENCES forum_post (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE forum_comment ADD CONSTRAINT FK_65B81F1DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_65B81F1D4B89032C ON forum_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_65B81F1DA76ED395 ON forum_comment (user_id)');
    }
}
