<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426114615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applications ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE applications ADD CONSTRAINT FK_F7C966F0A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('CREATE INDEX IDX_F7C966F0A76ED395 ON applications (user_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E93E030ACD');
        $this->addSql('DROP INDEX IDX_1483A5E93E030ACD ON users');
        $this->addSql('ALTER TABLE users DROP application_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `applications` DROP FOREIGN KEY FK_F7C966F0A76ED395');
        $this->addSql('DROP INDEX IDX_F7C966F0A76ED395 ON `applications`');
        $this->addSql('ALTER TABLE `applications` DROP user_id');
        $this->addSql('ALTER TABLE `users` ADD application_id INT NOT NULL');
        $this->addSql('ALTER TABLE `users` ADD CONSTRAINT FK_1483A5E93E030ACD FOREIGN KEY (application_id) REFERENCES applications (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E93E030ACD ON `users` (application_id)');
    }
}
