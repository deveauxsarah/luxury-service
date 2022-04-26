<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426113855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `applications` (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F7C966F053C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `categories` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `companies` (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, contact_name VARCHAR(255) NOT NULL, contact_email VARCHAR(255) NOT NULL, contact_phone INT NOT NULL, contact_job VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_8244AA3ABCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `offers` (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, job_type VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, reference INT NOT NULL, starting_date DATETIME NOT NULL, salary INT NOT NULL, created_at DATETIME NOT NULL, datetime INT NOT NULL, updated_at DATETIME NOT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_DA460427979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, application_id INT NOT NULL, gender SMALLINT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, birthdate DATETIME DEFAULT NULL, birthplace VARCHAR(255) DEFAULT NULL, picture LONGTEXT DEFAULT NULL, passport LONGTEXT DEFAULT NULL, cv LONGTEXT DEFAULT NULL, experience VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, disponibility TINYINT(1) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, files LONGTEXT DEFAULT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_admin TINYINT(1) NOT NULL, INDEX IDX_1483A5E9BCF5E72D (categorie_id), INDEX IDX_1483A5E93E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `applications` ADD CONSTRAINT FK_F7C966F053C674EE FOREIGN KEY (offer_id) REFERENCES `offers` (id)');
        $this->addSql('ALTER TABLE `companies` ADD CONSTRAINT FK_8244AA3ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES `categories` (id)');
        $this->addSql('ALTER TABLE `offers` ADD CONSTRAINT FK_DA460427979B1AD6 FOREIGN KEY (company_id) REFERENCES `companies` (id)');
        $this->addSql('ALTER TABLE `users` ADD CONSTRAINT FK_1483A5E9BCF5E72D FOREIGN KEY (categorie_id) REFERENCES `categories` (id)');
        $this->addSql('ALTER TABLE `users` ADD CONSTRAINT FK_1483A5E93E030ACD FOREIGN KEY (application_id) REFERENCES `applications` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `users` DROP FOREIGN KEY FK_1483A5E93E030ACD');
        $this->addSql('ALTER TABLE `companies` DROP FOREIGN KEY FK_8244AA3ABCF5E72D');
        $this->addSql('ALTER TABLE `users` DROP FOREIGN KEY FK_1483A5E9BCF5E72D');
        $this->addSql('ALTER TABLE `offers` DROP FOREIGN KEY FK_DA460427979B1AD6');
        $this->addSql('ALTER TABLE `applications` DROP FOREIGN KEY FK_F7C966F053C674EE');
        $this->addSql('DROP TABLE `applications`');
        $this->addSql('DROP TABLE `categories`');
        $this->addSql('DROP TABLE `companies`');
        $this->addSql('DROP TABLE `offers`');
        $this->addSql('DROP TABLE `users`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
