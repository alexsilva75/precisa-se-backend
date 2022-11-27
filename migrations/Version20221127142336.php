<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221127142336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE expertise_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expertise (id INT NOT NULL, title VARCHAR(255) NOT NULL, experience_level VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_expertise (user_id INT NOT NULL, expertise_id INT NOT NULL, PRIMARY KEY(user_id, expertise_id))');
        $this->addSql('CREATE INDEX IDX_227A526FA76ED395 ON user_expertise (user_id)');
        $this->addSql('CREATE INDEX IDX_227A526F9D5B92F9 ON user_expertise (expertise_id)');
        $this->addSql('ALTER TABLE user_expertise ADD CONSTRAINT FK_227A526FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_expertise ADD CONSTRAINT FK_227A526F9D5B92F9 FOREIGN KEY (expertise_id) REFERENCES expertise (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE expertise_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_expertise DROP CONSTRAINT FK_227A526FA76ED395');
        $this->addSql('ALTER TABLE user_expertise DROP CONSTRAINT FK_227A526F9D5B92F9');
        $this->addSql('DROP TABLE expertise');
        $this->addSql('DROP TABLE user_expertise');
    }
}
