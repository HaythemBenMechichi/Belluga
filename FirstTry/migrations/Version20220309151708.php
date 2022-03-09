<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309151708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_prod (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, ref_prod INT NOT NULL, nom_produit VARCHAR(255) NOT NULL, taux DOUBLE PRECISION NOT NULL, INDEX IDX_AA7F5D3CFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_prod ADD CONSTRAINT FK_AA7F5D3CFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD mail VARCHAR(255) NOT NULL, ADD activated_token VARCHAR(255) NOT NULL, DROP age, DROP email, DROP number, DROP nom, DROP prenom, DROP password, DROP flag, DROP role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_prod DROP FOREIGN KEY FK_AA7F5D3CFD02F13');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE event_prod');
        $this->addSql('ALTER TABLE user ADD age INT NOT NULL, ADD email VARCHAR(30) NOT NULL, ADD number VARCHAR(20) NOT NULL, ADD nom VARCHAR(30) NOT NULL, ADD prenom VARCHAR(30) NOT NULL, ADD password VARCHAR(200) NOT NULL, ADD flag INT NOT NULL, ADD role LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP mail, DROP activated_token');
    }
}
