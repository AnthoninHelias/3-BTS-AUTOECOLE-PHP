<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328085913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lecon_user (lecon_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3955EC52EC1308A5 (lecon_id), INDEX IDX_3955EC52A76ED395 (user_id), PRIMARY KEY(lecon_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lecon_user ADD CONSTRAINT FK_3955EC52EC1308A5 FOREIGN KEY (lecon_id) REFERENCES lecon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lecon_user ADD CONSTRAINT FK_3955EC52A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242E3256915B');
        $this->addSql('DROP INDEX IDX_94E6242E3256915B ON lecon');
        $this->addSql('ALTER TABLE lecon DROP relation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lecon_user DROP FOREIGN KEY FK_3955EC52EC1308A5');
        $this->addSql('ALTER TABLE lecon_user DROP FOREIGN KEY FK_3955EC52A76ED395');
        $this->addSql('DROP TABLE lecon_user');
        $this->addSql('ALTER TABLE lecon ADD relation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242E3256915B FOREIGN KEY (relation_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_94E6242E3256915B ON lecon (relation_id)');
    }
}
