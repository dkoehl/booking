<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331125032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deposite ADD CONSTRAINT FK_B04A29CF198B5B70 FOREIGN KEY (deposites_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE deposite ADD CONSTRAINT FK_B04A29CF3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_B04A29CF198B5B70 ON deposite (deposites_id)');
        $this->addSql('CREATE INDEX IDX_B04A29CF3301C60 ON deposite (booking_id)');
        $this->addSql('ALTER TABLE parking ADD parkingspot VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE2EFD2398');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE2EFD2398 ON booking');
        $this->addSql('ALTER TABLE booking DROP deposite_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking ADD deposite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE2EFD2398 FOREIGN KEY (deposite_id) REFERENCES deposite (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE2EFD2398 ON booking (deposite_id)');
        $this->addSql('ALTER TABLE deposite DROP FOREIGN KEY FK_B04A29CF198B5B70');
        $this->addSql('ALTER TABLE deposite DROP FOREIGN KEY FK_B04A29CF3301C60');
        $this->addSql('DROP INDEX IDX_B04A29CF198B5B70 ON deposite');
        $this->addSql('DROP INDEX IDX_B04A29CF3301C60 ON deposite');
        $this->addSql('ALTER TABLE parking DROP parkingspot');
    }
}
