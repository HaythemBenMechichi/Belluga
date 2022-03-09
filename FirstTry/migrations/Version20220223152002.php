<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223152002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_prod DROP FOREIGN KEY FK_AA7F5D3CFD02F13');
        $this->addSql('ALTER TABLE event_prod CHANGE evenement_id evenement_id INT NOT NULL');
        $this->addSql('ALTER TABLE event_prod ADD CONSTRAINT FK_AA7F5D3CFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_prod DROP FOREIGN KEY FK_AA7F5D3CFD02F13');
        $this->addSql('ALTER TABLE event_prod CHANGE evenement_id evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_prod ADD CONSTRAINT FK_AA7F5D3CFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
    }
}
