<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912163049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking CHANGE bookedroom_id bookedroom_id INT DEFAULT NULL, CHANGE guest_id guest_id INT DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE booking_id booking_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL, CHANGE house house VARCHAR(255) DEFAULT NULL, CHANGE hidden hidden TINYINT(1) DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory ADD inventory_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE closets closets INT DEFAULT NULL, CHANGE chairs chairs INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT NULL, CHANGE walls walls VARCHAR(255) DEFAULT NULL, CHANGE windows windows INT DEFAULT NULL, CHANGE doors doors VARCHAR(255) DEFAULT NULL, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A369EEA759 FOREIGN KEY (inventory_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A369EEA759 ON inventory (inventory_id)');
        $this->addSql('ALTER TABLE payment ADD payments_id INT DEFAULT NULL, CHANGE payment payment INT DEFAULT NULL, CHANGE number number VARCHAR(255) DEFAULT NULL, CHANGE securitynumber securitynumber VARCHAR(255) DEFAULT NULL, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DBBC61482 FOREIGN KEY (payments_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DBBC61482 ON payment (payments_id)');
        $this->addSql('ALTER TABLE damage ADD damage_id INT DEFAULT NULL, CHANGE price price VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE damage ADD CONSTRAINT FK_11C8546C6CE425B7 FOREIGN KEY (damage_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_11C8546C6CE425B7 ON damage (damage_id)');
        $this->addSql('ALTER TABLE price ADD prices_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE price price VARCHAR(255) DEFAULT NULL, CHANGE tax tax VARCHAR(255) DEFAULT NULL, CHANGE amount amount VARCHAR(255) DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE hidden hidden INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D9D9C9DE39 FOREIGN KEY (prices_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_CAC822D9D9C9DE39 ON price (prices_id)');
        $this->addSql('ALTER TABLE parking ADD parking_id INT DEFAULT NULL, CHANGE carplate carplate VARCHAR(255) DEFAULT NULL, CHANGE startdate startdate DATETIME DEFAULT NULL, CHANGE enddate enddate DATETIME DEFAULT NULL, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT FK_B237527AF17B2DD FOREIGN KEY (parking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_B237527AF17B2DD ON parking (parking_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking CHANGE bookedroom_id bookedroom_id INT DEFAULT NULL, CHANGE guest_id guest_id INT DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE damage DROP FOREIGN KEY FK_11C8546C6CE425B7');
        $this->addSql('DROP INDEX IDX_11C8546C6CE425B7 ON damage');
        $this->addSql('ALTER TABLE damage DROP damage_id, CHANGE price price VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE guest CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A369EEA759');
        $this->addSql('DROP INDEX IDX_B12D4A369EEA759 ON inventory');
        $this->addSql('ALTER TABLE inventory DROP inventory_id, CHANGE beds beds INT DEFAULT NULL, CHANGE closets closets INT DEFAULT NULL, CHANGE chairs chairs INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE walls walls VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE windows windows INT DEFAULT NULL, CHANGE doors doors VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parking DROP FOREIGN KEY FK_B237527AF17B2DD');
        $this->addSql('DROP INDEX IDX_B237527AF17B2DD ON parking');
        $this->addSql('ALTER TABLE parking DROP parking_id, CHANGE carplate carplate VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE startdate startdate DATETIME DEFAULT \'NULL\', CHANGE enddate enddate DATETIME DEFAULT \'NULL\', CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DBBC61482');
        $this->addSql('DROP INDEX IDX_6D28840DBBC61482 ON payment');
        $this->addSql('ALTER TABLE payment DROP payments_id, CHANGE payment payment INT DEFAULT NULL, CHANGE number number VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE securitynumber securitynumber VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE hidden hidden INT DEFAULT NULL, CHANGE deleted deleted INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D9D9C9DE39');
        $this->addSql('DROP INDEX IDX_CAC822D9D9C9DE39 ON price');
        $this->addSql('ALTER TABLE price DROP prices_id, CHANGE type type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE price price VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE tax tax VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE amount amount VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE deleted deleted INT DEFAULT NULL, CHANGE hidden hidden INT DEFAULT NULL, CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room CHANGE booking_id booking_id INT DEFAULT NULL, CHANGE beds beds INT DEFAULT NULL, CHANGE floor floor VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE house house VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE hidden hidden TINYINT(1) DEFAULT \'NULL\', CHANGE deleted deleted TINYINT(1) DEFAULT \'NULL\', CHANGE crdate crdate INT DEFAULT NULL, CHANGE tstamp tstamp INT DEFAULT NULL');
    }
}
