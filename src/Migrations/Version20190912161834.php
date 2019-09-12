<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912161834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parking (id INT AUTO_INCREMENT NOT NULL, carplate VARCHAR(255) DEFAULT NULL, startdate DATETIME DEFAULT NULL, enddate DATETIME DEFAULT NULL, hidden INT DEFAULT NULL, deleted INT DEFAULT NULL, crdate INT DEFAULT NULL, tstamp INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking CHANGE bookedroom_id bookedroom_id INT DEFAULT NULL, CHANGE guest_id guest_id INT DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE booking_id booking_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL, CHANGE house house VARCHAR(255) DEFAULT NULL, CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory ADD hidden INT DEFAULT NULL, ADD deleted INT DEFAULT NULL, ADD crdate INT DEFAULT NULL, ADD tstamp INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE closets closets INT DEFAULT NULL, CHANGE chairs chairs INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL, CHANGE walls walls VARCHAR(255) DEFAULT NULL, CHANGE windows windows INT DEFAULT NULL, CHANGE doors doors VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE parking');
        $this->addSql('ALTER TABLE booking CHANGE bookedroom_id bookedroom_id INT DEFAULT NULL, CHANGE guest_id guest_id INT DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory DROP hidden, DROP deleted, DROP crdate, DROP tstamp, CHANGE beds beds INT DEFAULT NULL, CHANGE closets closets INT DEFAULT NULL, CHANGE chairs chairs INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE walls walls VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE windows windows INT DEFAULT NULL, CHANGE doors doors VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE room CHANGE booking_id booking_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE house house VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
    }
}
