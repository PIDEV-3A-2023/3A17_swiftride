<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321142946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accident CHANGE id_voiture id_voiture INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis CHANGE id_voiture id_voiture INT DEFAULT NULL, CHANGE id_client id_client INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entreprise_partenaire CHANGE id_admin id_admin INT DEFAULT NULL');
        $this->addSql('ALTER TABLE maintenance CHANGE id_voiture id_voiture INT DEFAULT NULL, CHANGE id_garage id_garage INT DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel CHANGE id_garage id_garage INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE idrole idrole INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B384A67BCA ON utilisateur (idrole)');
        $this->addSql('ALTER TABLE voiture CHANGE id_entreprise_partenaire id_entreprise_partenaire INT DEFAULT NULL, CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE accident CHANGE id_voiture id_voiture INT NOT NULL');
        $this->addSql('ALTER TABLE voiture CHANGE id_entreprise_partenaire id_entreprise_partenaire INT NOT NULL, CHANGE id_utilisateur id_utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE avis CHANGE id_client id_client INT NOT NULL, CHANGE id_voiture id_voiture INT NOT NULL');
        $this->addSql('ALTER TABLE entreprise_partenaire CHANGE id_admin id_admin INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_1D1C63B384A67BCA ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE idrole idrole INT NOT NULL');
        $this->addSql('ALTER TABLE maintenance CHANGE id_garage id_garage INT NOT NULL, CHANGE id_voiture id_voiture INT NOT NULL');
        $this->addSql('ALTER TABLE materiel CHANGE id_garage id_garage INT NOT NULL');
    }
}
