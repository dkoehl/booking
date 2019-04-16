<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415123211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room CHANGE booking_id booking_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL, CHANGE house house VARCHAR(255) DEFAULT NULL, CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD bookedroom_id INT DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE5A1882D0 FOREIGN KEY (bookedroom_id) REFERENCES room (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE5A1882D0 ON booking (bookedroom_id)');
        $this->addSql('ALTER TABLE guest CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE5A1882D0');
        $this->addSql('DROP INDEX IDX_E00CEDDE5A1882D0 ON booking');
        $this->addSql('ALTER TABLE booking DROP bookedroom_id, CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE booking_id booking_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE house house VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
    }
}
