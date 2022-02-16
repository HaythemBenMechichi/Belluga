<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211181853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, id_sous_cat_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, quantite INT NOT NULL, prix DOUBLE PRECISION NOT NULL, image_p VARCHAR(255) NOT NULL, INDEX IDX_29A5EC272EA09643 (id_sous_cat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categorie (id INT AUTO_INCREMENT NOT NULL, id_cat_id INT DEFAULT NULL, nom_sous VARCHAR(255) NOT NULL, stat_sc INT NOT NULL, INDEX IDX_52743D7BC09A1CAE (id_cat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC272EA09643 FOREIGN KEY (id_sous_cat_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BC09A1CAE FOREIGN KEY (id_cat_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC272EA09643');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE sous_categorie');
        $this->addSql('ALTER TABLE categorie CHANGE nom_c nom_c VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
