<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113203417 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_event AS SELECT id, productId_uuid, productStatus_status, eventTime_dateTime FROM product_event');
        $this->addSql('DROP TABLE product_event');
        $this->addSql('CREATE TABLE product_event (productId_uuid VARCHAR(100) NOT NULL COLLATE BINARY, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL, eventId INTEGER NOT NULL, PRIMARY KEY(eventId, productId_uuid))');
        $this->addSql('INSERT INTO product_event (eventId, productId_uuid, productStatus_status, eventTime_dateTime) SELECT id, productId_uuid, productStatus_status, eventTime_dateTime FROM __temp__product_event');
        $this->addSql('DROP TABLE __temp__product_event');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_event AS SELECT eventId, productId_uuid, productStatus_status, eventTime_dateTime FROM product_event');
        $this->addSql('DROP TABLE product_event');
        $this->addSql('CREATE TABLE product_event (id INTEGER NOT NULL, productId_uuid VARCHAR(100) NOT NULL, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL, PRIMARY KEY(id, productId_uuid))');
        $this->addSql('INSERT INTO product_event (id, productId_uuid, productStatus_status, eventTime_dateTime) SELECT eventId, productId_uuid, productStatus_status, eventTime_dateTime FROM __temp__product_event');
        $this->addSql('DROP TABLE __temp__product_event');
    }
}
