<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920115607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase_have_product DROP FOREIGN KEY FK_2F48694CD71E064B');
        $this->addSql('DROP INDEX IDX_2F48694CD71E064B ON purchase_have_product');
        $this->addSql('ALTER TABLE purchase_have_product CHANGE id_article_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE purchase_have_product ADD CONSTRAINT FK_2F48694C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_2F48694C7294869C ON purchase_have_product (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase_have_product DROP FOREIGN KEY FK_2F48694C7294869C');
        $this->addSql('DROP INDEX IDX_2F48694C7294869C ON purchase_have_product');
        $this->addSql('ALTER TABLE purchase_have_product CHANGE article_id id_article_id INT NOT NULL');
        $this->addSql('ALTER TABLE purchase_have_product ADD CONSTRAINT FK_2F48694CD71E064B FOREIGN KEY (id_article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_2F48694CD71E064B ON purchase_have_product (id_article_id)');
    }
}
