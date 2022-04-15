<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220413081436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C19B7DBAC8');
        $this->addSql('DROP INDEX IDX_64C19C19B7DBAC8 ON category');
        $this->addSql('ALTER TABLE category DROP tableau_competence_id');
        $this->addSql('ALTER TABLE tableau_competence ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE tableau_competence ADD CONSTRAINT FK_1358693D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_1358693D12469DE2 ON tableau_competence (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD tableau_competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19B7DBAC8 FOREIGN KEY (tableau_competence_id) REFERENCES tableau_competence (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_64C19C19B7DBAC8 ON category (tableau_competence_id)');
        $this->addSql('ALTER TABLE tableau_competence DROP FOREIGN KEY FK_1358693D12469DE2');
        $this->addSql('DROP INDEX IDX_1358693D12469DE2 ON tableau_competence');
        $this->addSql('ALTER TABLE tableau_competence DROP category_id');
    }
}
