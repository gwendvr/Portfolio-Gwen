<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426084124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE days DROP day');
        $this->addSql('ALTER TABLE week DROP FOREIGN KEY FK_5B5A69C09C24126');
        $this->addSql('DROP INDEX IDX_5B5A69C09C24126 ON week');
        $this->addSql('ALTER TABLE week ADD day VARCHAR(255) NOT NULL, CHANGE day_id tasks_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE week ADD CONSTRAINT FK_5B5A69C0E3272D31 FOREIGN KEY (tasks_id) REFERENCES days (id)');
        $this->addSql('CREATE INDEX IDX_5B5A69C0E3272D31 ON week (tasks_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE days ADD day VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE week DROP FOREIGN KEY FK_5B5A69C0E3272D31');
        $this->addSql('DROP INDEX IDX_5B5A69C0E3272D31 ON week');
        $this->addSql('ALTER TABLE week DROP day, CHANGE tasks_id day_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE week ADD CONSTRAINT FK_5B5A69C09C24126 FOREIGN KEY (day_id) REFERENCES days (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5B5A69C09C24126 ON week (day_id)');
    }
}
