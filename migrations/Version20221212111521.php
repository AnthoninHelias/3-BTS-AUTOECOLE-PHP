<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212111521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD relation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6343256915B FOREIGN KEY (relation_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_497DD6343256915B ON categorie (relation_id)');
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242E64F5D57C');
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242EA0B98FBF');
        $this->addSql('DROP INDEX IDX_94E6242EA0B98FBF ON lecon');
        $this->addSql('DROP INDEX IDX_94E6242E64F5D57C ON lecon');
        $this->addSql('ALTER TABLE lecon ADD relation_id INT DEFAULT NULL, DROP idmoniteur_id, DROP ideleve_id');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242E3256915B FOREIGN KEY (relation_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_94E6242E3256915B ON lecon (relation_id)');
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE64864F5D57C');
        $this->addSql('DROP INDEX IDX_1DAAE64864F5D57C ON licence');
        $this->addSql('ALTER TABLE licence ADD relation_id INT DEFAULT NULL, DROP idmoniteur_id');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE6483256915B FOREIGN KEY (relation_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1DAAE6483256915B ON licence (relation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242E3256915B');
        $this->addSql('DROP INDEX IDX_94E6242E3256915B ON lecon');
        $this->addSql('ALTER TABLE lecon ADD idmoniteur_id INT NOT NULL, ADD ideleve_id INT NOT NULL, DROP relation_id');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242E64F5D57C FOREIGN KEY (idmoniteur_id) REFERENCES moniteur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242EA0B98FBF FOREIGN KEY (ideleve_id) REFERENCES eleve (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_94E6242EA0B98FBF ON lecon (ideleve_id)');
        $this->addSql('CREATE INDEX IDX_94E6242E64F5D57C ON lecon (idmoniteur_id)');
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE6483256915B');
        $this->addSql('DROP INDEX IDX_1DAAE6483256915B ON licence');
        $this->addSql('ALTER TABLE licence ADD idmoniteur_id INT NOT NULL, DROP relation_id');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE64864F5D57C FOREIGN KEY (idmoniteur_id) REFERENCES moniteur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1DAAE64864F5D57C ON licence (idmoniteur_id)');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD6343256915B');
        $this->addSql('DROP INDEX IDX_497DD6343256915B ON categorie');
        $this->addSql('ALTER TABLE categorie DROP relation_id');
    }
}
