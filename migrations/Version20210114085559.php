<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114085559 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_event AS SELECT productId_uuid, productStatus_status, eventTime_dateTime, eventId FROM product_event');
        $this->addSql('DROP TABLE product_event');
        $this->addSql('CREATE TABLE product_event (product_id VARCHAR(100) DEFAULT NULL, productId_uuid VARCHAR(100) NOT NULL COLLATE BINARY, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL, eventId INTEGER NOT NULL, PRIMARY KEY(eventId, productId_uuid), CONSTRAINT FK_9AF271FB4584665A FOREIGN KEY (product_id) REFERENCES product (productId_uuid) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_event (productId_uuid, productStatus_status, eventTime_dateTime, eventId) SELECT productId_uuid, productStatus_status, eventTime_dateTime, eventId FROM __temp__product_event');
        $this->addSql('DROP TABLE __temp__product_event');
        $this->addSql('CREATE INDEX IDX_9AF271FB4584665A ON product_event (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9AF271FB4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_event AS SELECT eventId, productId_uuid, productStatus_status, eventTime_dateTime FROM product_event');
        $this->addSql('DROP TABLE product_event');
        $this->addSql('CREATE TABLE product_event (eventId INTEGER NOT NULL, productId_uuid VARCHAR(100) NOT NULL, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL, PRIMARY KEY(eventId, productId_uuid))');
        $this->addSql('INSERT INTO product_event (eventId, productId_uuid, productStatus_status, eventTime_dateTime) SELECT eventId, productId_uuid, productStatus_status, eventTime_dateTime FROM __temp__product_event');
        $this->addSql('DROP TABLE __temp__product_event');
    }
}
