<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920115900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase_have_product DROP FOREIGN KEY FK_2F48694C4D9D734E');
        $this->addSql('DROP INDEX IDX_2F48694C4D9D734E ON purchase_have_product');
        $this->addSql('ALTER TABLE purchase_have_product CHANGE id_purchase_id purchase_id INT NOT NULL');
        $this->addSql('ALTER TABLE purchase_have_product ADD CONSTRAINT FK_2F48694C558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('CREATE INDEX IDX_2F48694C558FBEB9 ON purchase_have_product (purchase_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase_have_product DROP FOREIGN KEY FK_2F48694C558FBEB9');
        $this->addSql('DROP INDEX IDX_2F48694C558FBEB9 ON purchase_have_product');
        $this->addSql('ALTER TABLE purchase_have_product CHANGE purchase_id id_purchase_id INT NOT NULL');
        $this->addSql('ALTER TABLE purchase_have_product ADD CONSTRAINT FK_2F48694C4D9D734E FOREIGN KEY (id_purchase_id) REFERENCES purchase (id)');
        $this->addSql('CREATE INDEX IDX_2F48694C4D9D734E ON purchase_have_product (id_purchase_id)');
    }
}
