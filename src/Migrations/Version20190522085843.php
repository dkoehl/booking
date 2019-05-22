<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190522085843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, bookedroom_id INT DEFAULT NULL, guest_id INT DEFAULT NULL, bookingfrom INT DEFAULT NULL, bookingtill INT DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, hidden TINYINT(1) DEFAULT NULL, crdate INT DEFAULT NULL, tstamp INT DEFAULT NULL, INDEX IDX_E00CEDDE5A1882D0 (bookedroom_id), INDEX IDX_E00CEDDE9A4AA658 (guest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, booking_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, beds INT DEFAULT NULL, floor VARCHAR(255) DEFAULT NULL, house VARCHAR(255) DEFAULT NULL, hidden TINYINT(1) DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, crdate INT DEFAULT NULL, tstamp INT DEFAULT NULL, INDEX IDX_729F519B3301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guest (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL, hidden TINYINT(1) DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, crdate INT DEFAULT NULL, tstamp INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE5A1882D0 FOREIGN KEY (bookedroom_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B3301C60');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE5A1882D0');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9A4AA658');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE guest');
    }
}
