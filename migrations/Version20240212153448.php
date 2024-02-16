<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212153448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE forum_comment ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE forum_comment ADD post_id INT NOT NULL');
    
        //$this->addSql('ALTER TABLE forum_comment ADD CONSTRAINT IDX_996BCC5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
       // $this->addSql('ALTER TABLE forum_comment ADD CONSTRAINT FK_67890 FOREIGN KEY (post_id) REFERENCES forum_post (id)');
    }

    public function down(Schema $schema): void
    {
    
    }
}
