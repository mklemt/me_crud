<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114100013 extends AbstractMigration
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
        $this->addSql('CREATE TABLE product_event (eventId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL, productId VARCHAR(100) NOT NULL, CONSTRAINT FK_9AF271FB36799605 FOREIGN KEY (productId) REFERENCES product (productId_uuid) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_event (productId, eventId, productStatus_status, eventTime_dateTime) SELECT product_id, eventId, productStatus_status, eventTime_dateTime FROM __temp__product_event');
        $this->addSql('DROP TABLE __temp__product_event');
        $this->addSql('CREATE INDEX IDX_9AF271FB36799605 ON product_event (productId)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9AF271FB36799605');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_event AS SELECT productId, eventId, productStatus_status, eventTime_dateTime FROM product_event');
        $this->addSql('DROP TABLE product_event');
        $this->addSql('CREATE TABLE product_event (eventId INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL, product_id VARCHAR(100) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO product_event (product_id, eventId, productStatus_status, eventTime_dateTime) SELECT productId, eventId, productStatus_status, eventTime_dateTime FROM __temp__product_event');
        $this->addSql('DROP TABLE __temp__product_event');
        $this->addSql('CREATE INDEX IDX_9AF271FB4584665A ON product_event (product_id)');
    }
}
