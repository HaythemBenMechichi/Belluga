<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223143526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(30) NOT NULL, ADD prenom VARCHAR(30) NOT NULL, ADD role VARCHAR(25) NOT NULL, ADD mdp VARCHAR(20) NOT NULL, DROP roles, DROP password, DROP img, DROP last_name, DROP username, CHANGE email email VARCHAR(30) NOT NULL, CHANGE number number VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, ADD img VARCHAR(50) NOT NULL, ADD last_name VARCHAR(35) NOT NULL, ADD username VARCHAR(35) NOT NULL, DROP nom, DROP prenom, DROP role, DROP mdp, CHANGE email email VARCHAR(180) NOT NULL, CHANGE number number VARCHAR(25) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
