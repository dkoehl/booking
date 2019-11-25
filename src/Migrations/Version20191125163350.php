<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191125163350 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE occupancy ADD occupancies_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE occupancy ADD CONSTRAINT FK_850E50F634BFF5B0 FOREIGN KEY (occupancies_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_850E50F634BFF5B0 ON occupancy (occupancies_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE occupancy DROP FOREIGN KEY FK_850E50F634BFF5B0');
        $this->addSql('DROP INDEX IDX_850E50F634BFF5B0 ON occupancy');
        $this->addSql('ALTER TABLE occupancy DROP occupancies_id');
    }
}
