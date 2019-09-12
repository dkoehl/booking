<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912162420 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE damage (id INT AUTO_INCREMENT NOT NULL, damageart VARCHAR(255) NOT NULL, damagetext LONGTEXT DEFAULT NULL, price VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking CHANGE bookedroom_id bookedroom_id INT DEFAULT NULL, CHANGE guest_id guest_id INT DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE booking_id booking_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL, CHANGE house house VARCHAR(255) DEFAULT NULL, CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory CHANGE beds beds INT DEFAULT NULL, CHANGE closets closets INT DEFAULT NULL, CHANGE chairs chairs INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL, CHANGE walls walls VARCHAR(255) DEFAULT NULL, CHANGE windows windows INT DEFAULT NULL, CHANGE doors doors VARCHAR(255) DEFAULT NULL, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment CHANGE payment payment INT DEFAULT NULL, CHANGE number number VARCHAR(255) DEFAULT NULL, CHANGE securitynumber securitynumber VARCHAR(255) DEFAULT NULL, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parking CHANGE carplate carplate VARCHAR(255) DEFAULT NULL, CHANGE startdate startdate DATETIME DEFAULT NULL, CHANGE enddate enddate DATETIME DEFAULT NULL, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE damage');
        $this->addSql('ALTER TABLE booking CHANGE bookedroom_id bookedroom_id INT DEFAULT NULL, CHANGE guest_id guest_id INT DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory CHANGE beds beds INT DEFAULT NULL, CHANGE closets closets INT DEFAULT NULL, CHANGE chairs chairs INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE walls walls VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE windows windows INT DEFAULT NULL, CHANGE doors doors VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parking CHANGE carplate carplate VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE startdate startdate DATETIME DEFAULT \'NULL\', CHANGE enddate enddate DATETIME DEFAULT \'NULL\', CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment CHANGE payment payment INT DEFAULT NULL, CHANGE number number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE securitynumber securitynumber VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE booking_id booking_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE house house VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
    }
}
