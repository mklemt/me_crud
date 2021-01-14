<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114101544 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9AF271FB4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_event AS SELECT product_id, eventId, productStatus_status, eventTime_dateTime FROM product_event');
        $this->addSql('DROP TABLE product_event');
        $this->addSql('CREATE TABLE product_event (product_id VARCHAR(100) NOT NULL COLLATE BINARY, eventId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL, productId_uuid VARCHAR(100) DEFAULT NULL, CONSTRAINT FK_9AF271FBEADD31F FOREIGN KEY (productId_uuid) REFERENCES product (productId_uuid) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_event (product_id, eventId, productStatus_status, eventTime_dateTime) SELECT product_id, eventId, productStatus_status, eventTime_dateTime FROM __temp__product_event');
        $this->addSql('DROP TABLE __temp__product_event');
        $this->addSql('CREATE INDEX IDX_9AF271FBEADD31F ON product_event (productId_uuid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9AF271FBEADD31F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_event AS SELECT product_id, eventId, productStatus_status, eventTime_dateTime FROM product_event');
        $this->addSql('DROP TABLE product_event');
        $this->addSql('CREATE TABLE product_event (product_id VARCHAR(100) NOT NULL, eventId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL)');
        $this->addSql('INSERT INTO product_event (product_id, eventId, productStatus_status, eventTime_dateTime) SELECT product_id, eventId, productStatus_status, eventTime_dateTime FROM __temp__product_event');
        $this->addSql('DROP TABLE __temp__product_event');
        $this->addSql('CREATE INDEX IDX_9AF271FB4584665A ON product_event (product_id)');
    }
}
