<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427082810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applications CHANGE offer_id offer_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE applications RENAME INDEX idx_f7c966f053c674ee TO offerId');
        $this->addSql('ALTER TABLE applications RENAME INDEX idx_f7c966f0a76ed395 TO userId');
        $this->addSql('ALTER TABLE companies CHANGE categorie_id categorie_id INT DEFAULT NULL, CHANGE contact_phone contact_phone VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE notes notes TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE companies RENAME INDEX idx_8244aa3abcf5e72d TO categorie_id');
        $this->addSql('ALTER TABLE offers CHANGE company_id company_id INT DEFAULT NULL, CHANGE content content TEXT NOT NULL, CHANGE reference reference VARCHAR(255) NOT NULL, CHANGE starting_date starting_date VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE notes notes TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE offers RENAME INDEX idx_da460427979b1ad6 TO companyId');
        $this->addSql('ALTER TABLE users CHANGE gender gender INT DEFAULT NULL, CHANGE birthdate birthdate VARCHAR(255) DEFAULT NULL, CHANGE picture picture TEXT DEFAULT NULL, CHANGE passport passport TEXT DEFAULT NULL, CHANGE cv cv TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE file file TEXT DEFAULT NULL, CHANGE notes notes TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE users RENAME INDEX idx_1483a5e9bcf5e72d TO categoryID');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applications CHANGE offer_id offer_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE applications RENAME INDEX userid TO IDX_F7C966F0A76ED395');
        $this->addSql('ALTER TABLE applications RENAME INDEX offerid TO IDX_F7C966F053C674EE');
        $this->addSql('ALTER TABLE companies CHANGE categorie_id categorie_id INT NOT NULL, CHANGE contact_phone contact_phone INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE notes notes LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE companies RENAME INDEX categorie_id TO IDX_8244AA3ABCF5E72D');
        $this->addSql('ALTER TABLE offers CHANGE company_id company_id INT NOT NULL, CHANGE content content LONGTEXT NOT NULL, CHANGE reference reference INT NOT NULL, CHANGE starting_date starting_date DATETIME NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE notes notes LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE offers RENAME INDEX companyid TO IDX_DA460427979B1AD6');
        $this->addSql('ALTER TABLE users CHANGE gender gender SMALLINT DEFAULT NULL, CHANGE birthdate birthdate DATETIME DEFAULT NULL, CHANGE picture picture LONGTEXT DEFAULT NULL, CHANGE passport passport LONGTEXT DEFAULT NULL, CHANGE cv cv LONGTEXT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE file file LONGTEXT DEFAULT NULL, CHANGE notes notes LONGTEXT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users RENAME INDEX categoryid TO IDX_1483A5E9BCF5E72D');
    }
}
