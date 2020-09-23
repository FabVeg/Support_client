<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200917093240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2ED5CA9E6');
        $this->addSql('DROP INDEX IDX_E19D9AD2ED5CA9E6 ON service');
        $this->addSql('ALTER TABLE service DROP service_id, DROP title');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD service_id INT DEFAULT NULL, ADD title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2ED5CA9E6 FOREIGN KEY (service_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2ED5CA9E6 ON service (service_id)');
    }
}
