<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260726093712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, categorie VARCHAR(100) NOT NULL, niveau INT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, date_envoi DATETIME NOT NULL, lu TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, etablissement VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_debut DATETIME DEFAULT NULL, date_fin DATETIME DEFAULT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, titre VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(50) DEFAULT NULL, localisation VARCHAR(255) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, lien_projet_deploye VARCHAR(100) DEFAULT NULL, lien_github VARCHAR(100) DEFAULT NULL, lien_linkedin VARCHAR(100) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, categorie VARCHAR(100) NOT NULL, image VARCHAR(255) NOT NULL, lien VARCHAR(255) DEFAULT NULL, technologies VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, date_visite DATETIME NOT NULL, adresse_ip VARCHAR(50) NOT NULL, page_visitee VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE parcours');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE visite');
    }
}
