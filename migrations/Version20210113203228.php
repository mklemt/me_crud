<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113203228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (productId_uuid VARCHAR(100) NOT NULL, productName_name VARCHAR(100) NOT NULL, createdDate_dateTime DATETIME NOT NULL, currentStatus_status INTEGER NOT NULL, PRIMARY KEY(productId_uuid))');
        $this->addSql('CREATE TABLE product_event (id INTEGER NOT NULL, productId_uuid VARCHAR(100) NOT NULL, productStatus_status INTEGER NOT NULL, eventTime_dateTime DATETIME NOT NULL, PRIMARY KEY(id, productId_uuid))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_event');
    }
}
