<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111205656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09953C1C61 ON customer (source_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E0979839897 ON customer (dest_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398953C1C61 ON "order" (source_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F529939879839897 ON "order" (dest_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD953C1C61 ON product (source_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD79839897 ON product (dest_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_F5299398953C1C61');
        $this->addSql('DROP INDEX UNIQ_F529939879839897');
        $this->addSql('DROP INDEX UNIQ_81398E09953C1C61');
        $this->addSql('DROP INDEX UNIQ_81398E0979839897');
        $this->addSql('DROP INDEX UNIQ_D34A04AD953C1C61');
        $this->addSql('DROP INDEX UNIQ_D34A04AD79839897');
    }
}
