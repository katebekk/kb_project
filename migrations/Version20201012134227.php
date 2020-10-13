<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201012134227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3C4663E4 ON `like` (page_id)');
        $this->addSql('ALTER TABLE page ADD holy_id INT NOT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620F62090B FOREIGN KEY (holy_id) REFERENCES `like` (id)');
        $this->addSql('CREATE INDEX IDX_140AB620F62090B ON page (holy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3C4663E4');
        $this->addSql('DROP INDEX IDX_AC6340B3C4663E4 ON `like`');
        $this->addSql('ALTER TABLE `like` DROP page_id');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620F62090B');
        $this->addSql('DROP INDEX IDX_140AB620F62090B ON page');
        $this->addSql('ALTER TABLE page DROP holy_id');
    }
}
