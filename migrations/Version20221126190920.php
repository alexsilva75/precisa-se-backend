<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126190920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user_project" ADD price FLOAT NOT NULL');
        $this->addSql('ALTER TABLE "user_project" ADD approved BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user_project" ADD approval_date TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user_project" DROP price');
        $this->addSql('ALTER TABLE "user_project" DROP approved');
        $this->addSql('ALTER TABLE "user_project" DROP approval_date');
    }
}
