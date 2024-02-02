<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126071235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE abstract_entity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_item_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, source_id INT NOT NULL, transfer_status VARCHAR(255) NOT NULL, dest_id VARCHAR(255) DEFAULT NULL, transfer_data VARCHAR(65000) DEFAULT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09953C1C61 ON customer (source_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E0979839897 ON customer (dest_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7927C74 ON customer (email)');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, customer_id INT DEFAULT NULL, source_id INT NOT NULL, transfer_status VARCHAR(255) NOT NULL, dest_id VARCHAR(255) DEFAULT NULL, transfer_data VARCHAR(65000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398953C1C61 ON "order" (source_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F529939879839897 ON "order" (dest_id)');
        $this->addSql('CREATE INDEX IDX_F52993989395C3F3 ON "order" (customer_id)');
        $this->addSql('CREATE TABLE "order_item" (id INT NOT NULL, order_entity_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52EA1F093DA206A5 ON "order_item" (order_entity_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, source_id INT NOT NULL, transfer_status VARCHAR(255) NOT NULL, dest_id VARCHAR(255) DEFAULT NULL, transfer_data VARCHAR(65000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD953C1C61 ON product (source_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD79839897 ON product (dest_id)');
        $this->addSql('CREATE TABLE product_order_item (product_id INT NOT NULL, order_item_id INT NOT NULL, PRIMARY KEY(product_id, order_item_id))');
        $this->addSql('CREATE INDEX IDX_C18D40224584665A ON product_order_item (product_id)');
        $this->addSql('CREATE INDEX IDX_C18D4022E415FB15 ON product_order_item (order_item_id)');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order_item" ADD CONSTRAINT FK_52EA1F093DA206A5 FOREIGN KEY (order_entity_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_order_item ADD CONSTRAINT FK_C18D40224584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_order_item ADD CONSTRAINT FK_C18D4022E415FB15 FOREIGN KEY (order_item_id) REFERENCES "order_item" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE abstract_entity_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_item_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE "order_item" DROP CONSTRAINT FK_52EA1F093DA206A5');
        $this->addSql('ALTER TABLE product_order_item DROP CONSTRAINT FK_C18D40224584665A');
        $this->addSql('ALTER TABLE product_order_item DROP CONSTRAINT FK_C18D4022E415FB15');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE "order_item"');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_order_item');
    }
}
