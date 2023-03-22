<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321084645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY garage_maintenance');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY voiture_maintenance');
        $this->addSql('ALTER TABLE accident DROP FOREIGN KEY voiture_accident');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY moyen_transport_station');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY utilisateur_avis');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY voiture_avis');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY garage_materiel');
        $this->addSql('ALTER TABLE entreprise_partenaire DROP FOREIGN KEY FKrole');
        $this->addSql('ALTER TABLE moyen_transport DROP FOREIGN KEY utilisateur_moyen_transport');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY entreprise_voiture');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY utilisateu_voiture');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY moy_reservation');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY utilisateur_reservation');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY voiture_reservation');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE accident');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE entreprise_partenaire');
        $this->addSql('DROP TABLE moyen_transport');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE garage');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, id_voiture INT NOT NULL, id_garage INT NOT NULL, date_maintenance DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, type VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_voiture (id_voiture), INDEX id_garage (id_garage), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE accident (id INT AUTO_INCREMENT NOT NULL, id_voiture INT NOT NULL, type INT NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, lieu VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_voiture (id_voiture), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, id_moy INT NOT NULL, ville VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_station VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_moy (id_moy), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, id_voiture INT NOT NULL, id_client INT NOT NULL, commentaire VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etoile INT NOT NULL, INDEX id_voiture (id_voiture), INDEX id_client (id_client), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE materiel (id_garage INT NOT NULL, id INT DEFAULT NULL, nom INT NOT NULL, INDEX id_garage (id_garage)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entreprise_partenaire (id INT AUTO_INCREMENT NOT NULL, idrole INT NOT NULL, nom_entreprise VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_admin VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom_admin VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nb_voiture INT NOT NULL, tel VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, matricule VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, login VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX FKrole (idrole), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE moyen_transport (id INT AUTO_INCREMENT NOT NULL, id_admin INT NOT NULL, type VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numero_trans INT NOT NULL, nb_station INT NOT NULL, INDEX id_admin (id_admin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, id_entreprise_partenaire INT NOT NULL, id_utilisateur INT NOT NULL, marque VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, model VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etat VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, couleur VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etat_technique VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, matricule VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_circulation DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX id_entreprise_partenaire (id_entreprise_partenaire), INDEX id_voiture (id_utilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_client INT NOT NULL, id_voiture INT DEFAULT NULL, id_moy INT DEFAULT NULL, date_debut DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, date_fin DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX id_client (id_client), INDEX id_voiture (id_voiture), INDEX id_moy (id_moy), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, idrole INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, cin VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_naiss VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, age VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, num_permis VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, num_tel VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, login VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, photo_personel VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, photo_permis VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX FK (idrole), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE garage (id INT AUTO_INCREMENT NOT NULL, matricule_garage VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT garage_maintenance FOREIGN KEY (id_garage) REFERENCES garage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT voiture_maintenance FOREIGN KEY (id_voiture) REFERENCES voiture (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE accident ADD CONSTRAINT voiture_accident FOREIGN KEY (id_voiture) REFERENCES voiture (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT moyen_transport_station FOREIGN KEY (id_moy) REFERENCES moyen_transport (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT utilisateur_avis FOREIGN KEY (id_client) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT voiture_avis FOREIGN KEY (id_voiture) REFERENCES voiture (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT garage_materiel FOREIGN KEY (id_garage) REFERENCES garage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE entreprise_partenaire ADD CONSTRAINT FKrole FOREIGN KEY (idrole) REFERENCES role (id)');
        $this->addSql('ALTER TABLE moyen_transport ADD CONSTRAINT utilisateur_moyen_transport FOREIGN KEY (id_admin) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT entreprise_voiture FOREIGN KEY (id_entreprise_partenaire) REFERENCES entreprise_partenaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT utilisateu_voiture FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT moy_reservation FOREIGN KEY (id_moy) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT utilisateur_reservation FOREIGN KEY (id_client) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT voiture_reservation FOREIGN KEY (id_voiture) REFERENCES voiture (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK FOREIGN KEY (idrole) REFERENCES role (id)');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
