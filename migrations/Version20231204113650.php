<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204113650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE order_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE entity_abstract_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE abstract_entity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT fk_52ea1f094584665a');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT fk_52ea1f093da206a5');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('ALTER TABLE customer ADD transfer_data VARCHAR(65000) DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ALTER dest_id DROP NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD transfer_data VARCHAR(65000) DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ALTER dest_id DROP NOT NULL');
        $this->addSql('ALTER TABLE product ADD transfer_data VARCHAR(65000) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ALTER dest_id DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE abstract_entity_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE order_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE entity_abstract_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE order_item (id INT NOT NULL, product_id INT NOT NULL, order_entity_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_52ea1f093da206a5 ON order_item (order_entity_id)');
        $this->addSql('CREATE INDEX idx_52ea1f094584665a ON order_item (product_id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT fk_52ea1f094584665a FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT fk_52ea1f093da206a5 FOREIGN KEY (order_entity_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" DROP transfer_data');
        $this->addSql('ALTER TABLE "order" ALTER dest_id SET NOT NULL');
        $this->addSql('ALTER TABLE product DROP transfer_data');
        $this->addSql('ALTER TABLE product ALTER dest_id SET NOT NULL');
        $this->addSql('ALTER TABLE customer DROP transfer_data');
        $this->addSql('ALTER TABLE customer ALTER dest_id SET NOT NULL');
    }
}
