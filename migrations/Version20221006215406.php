<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221006215406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE associative_experience (id INT AUTO_INCREMENT NOT NULL, curriculum_vitae_id INT DEFAULT NULL, description LONGTEXT NOT NULL, period LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', organization VARCHAR(255) NOT NULL, INDEX IDX_675BAB854AF29A35 (curriculum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, linkedin_account VARCHAR(255) DEFAULT NULL, certificates LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_1FC99844A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educational_experience (id INT AUTO_INCREMENT NOT NULL, curriclum_vitae_id INT NOT NULL, university VARCHAR(10) NOT NULL, period LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', description LONGTEXT NOT NULL, INDEX IDX_A5BDE64263358679 (curriclum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, service LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', email VARCHAR(255) NOT NULL, logo_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_interview (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date DATE NOT NULL, type TINYINT(1) NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_8ADD325A4AEAFEA (entreprise_id), INDEX IDX_8ADD325A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, job_name VARCHAR(255) NOT NULL, contract_type VARCHAR(50) NOT NULL, is_active TINYINT(1) NOT NULL, application_deadline DATETIME NOT NULL, description LONGTEXT NOT NULL, mission LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', qualifications LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_288A3A4EA4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, date DATETIME NOT NULL, status VARCHAR(50) NOT NULL, location VARCHAR(255) DEFAULT NULL, INDEX IDX_A1783804A76ED395 (user_id), INDEX IDX_A1783804A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional_experience (id INT AUTO_INCREMENT NOT NULL, curriculum_vitae_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, period LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_32FDB9BA4AF29A35 (curriculum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, role SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE associative_experience ADD CONSTRAINT FK_675BAB854AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('ALTER TABLE curriculum_vitae ADD CONSTRAINT FK_1FC99844A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE educational_experience ADD CONSTRAINT FK_A5BDE64263358679 FOREIGN KEY (curriclum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('ALTER TABLE job_interview ADD CONSTRAINT FK_8ADD325A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE job_interview ADD CONSTRAINT FK_8ADD325A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4EA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE job_request ADD CONSTRAINT FK_A1783804A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE job_request ADD CONSTRAINT FK_A1783804A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE professional_experience ADD CONSTRAINT FK_32FDB9BA4AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE associative_experience DROP FOREIGN KEY FK_675BAB854AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae DROP FOREIGN KEY FK_1FC99844A76ED395');
        $this->addSql('ALTER TABLE educational_experience DROP FOREIGN KEY FK_A5BDE64263358679');
        $this->addSql('ALTER TABLE job_interview DROP FOREIGN KEY FK_8ADD325A4AEAFEA');
        $this->addSql('ALTER TABLE job_interview DROP FOREIGN KEY FK_8ADD325A76ED395');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4EA4AEAFEA');
        $this->addSql('ALTER TABLE job_request DROP FOREIGN KEY FK_A1783804A76ED395');
        $this->addSql('ALTER TABLE job_request DROP FOREIGN KEY FK_A1783804A4AEAFEA');
        $this->addSql('ALTER TABLE professional_experience DROP FOREIGN KEY FK_32FDB9BA4AF29A35');
        $this->addSql('DROP TABLE associative_experience');
        $this->addSql('DROP TABLE curriculum_vitae');
        $this->addSql('DROP TABLE educational_experience');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE job_interview');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('DROP TABLE job_request');
        $this->addSql('DROP TABLE professional_experience');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
