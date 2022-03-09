<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223123809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_prod ADD evenement_id INT DEFAULT NULL, ADD nom_produit VARCHAR(255) NOT NULL, ADD taux DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE event_prod ADD CONSTRAINT FK_AA7F5D3CFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_AA7F5D3CFD02F13 ON event_prod (evenement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_prod DROP FOREIGN KEY FK_AA7F5D3CFD02F13');
        $this->addSql('DROP INDEX IDX_AA7F5D3CFD02F13 ON event_prod');
        $this->addSql('ALTER TABLE event_prod DROP evenement_id, DROP nom_produit, DROP taux');
    }
}
