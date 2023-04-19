<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221117134240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, prix DOUBLE PRECISION NOT NULL, codecategorie INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, sexe INT NOT NULL, datedenaissance DATE NOT NULL, adresse VARCHAR(50) NOT NULL, codepostal VARCHAR(50) NOT NULL, ville VARCHAR(50) NOT NULL, telephone VARCHAR(50) NOT NULL, nomutilisateur VARCHAR(55) NOT NULL, motdepasse VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gerant (id INT AUTO_INCREMENT NOT NULL, nomutilisateur VARCHAR(55) NOT NULL, motdepasse VARCHAR(55) NOT NULL, nom VARCHAR(55) NOT NULL, prenom VARCHAR(55) NOT NULL, sexe INT NOT NULL, datedenaissance DATE NOT NULL, adresse VARCHAR(55) NOT NULL, codepostal VARCHAR(55) NOT NULL, ville VARCHAR(55) NOT NULL, telephone VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecon (id INT AUTO_INCREMENT NOT NULL, idmoniteur_id INT NOT NULL, ideleve_id INT NOT NULL, immatriculation_id INT NOT NULL, date DATE NOT NULL, heure VARCHAR(50) NOT NULL, reglee INT NOT NULL, INDEX IDX_94E6242E64F5D57C (idmoniteur_id), INDEX IDX_94E6242EA0B98FBF (ideleve_id), INDEX IDX_94E6242E5FD1A365 (immatriculation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licence (id INT AUTO_INCREMENT NOT NULL, idmoniteur_id INT NOT NULL, codecategorie_id INT NOT NULL, dateobtention DATE NOT NULL, codelicence INT NOT NULL, INDEX IDX_1DAAE64864F5D57C (idmoniteur_id), INDEX IDX_1DAAE648AB09BC63 (codecategorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moniteur (id INT AUTO_INCREMENT NOT NULL, nomutilisateur VARCHAR(55) NOT NULL, motdepasse VARCHAR(55) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, sexe INT NOT NULL, datedenaissance DATE NOT NULL, adresse VARCHAR(55) NOT NULL, codepostal VARCHAR(55) NOT NULL, ville VARCHAR(55) NOT NULL, telephone VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, idcategorie_id INT NOT NULL, immatriculation VARCHAR(50) NOT NULL, marque VARCHAR(50) NOT NULL, modele VARCHAR(50) NOT NULL, annee INT NOT NULL, INDEX IDX_292FFF1DFA5A9824 (idcategorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242E64F5D57C FOREIGN KEY (idmoniteur_id) REFERENCES moniteur (id)');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242EA0B98FBF FOREIGN KEY (ideleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242E5FD1A365 FOREIGN KEY (immatriculation_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE64864F5D57C FOREIGN KEY (idmoniteur_id) REFERENCES moniteur (id)');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE648AB09BC63 FOREIGN KEY (codecategorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DFA5A9824 FOREIGN KEY (idcategorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242E64F5D57C');
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242EA0B98FBF');
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242E5FD1A365');
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE64864F5D57C');
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE648AB09BC63');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DFA5A9824');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE gerant');
        $this->addSql('DROP TABLE lecon');
        $this->addSql('DROP TABLE licence');
        $this->addSql('DROP TABLE moniteur');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
