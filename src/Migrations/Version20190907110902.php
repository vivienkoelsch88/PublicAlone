<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190907110902 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE batiments (id INT AUTO_INCREMENT NOT NULL, camp_id INT DEFAULT NULL, camp_connu_id INT DEFAULT NULL, INDEX IDX_124D799077075ABB (camp_id), INDEX IDX_124D79903DDF70AB (camp_connu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camp (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieux (id INT AUTO_INCREMENT NOT NULL, personnage_id INT DEFAULT NULL, nourriture_chasse INT NOT NULL, nourriture_cueillir INT NOT NULL, INDEX IDX_9E44A8AE5E315342 (personnage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressources (id INT AUTO_INCREMENT NOT NULL, camp_id INT DEFAULT NULL, batiments_id INT DEFAULT NULL, nombre INT NOT NULL, INDEX IDX_6A2CD5C777075ABB (camp_id), INDEX IDX_6A2CD5C76DC28240 (batiments_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE batiments ADD CONSTRAINT FK_124D799077075ABB FOREIGN KEY (camp_id) REFERENCES camp (id)');
        $this->addSql('ALTER TABLE batiments ADD CONSTRAINT FK_124D79903DDF70AB FOREIGN KEY (camp_connu_id) REFERENCES camp (id)');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AE5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id)');
        $this->addSql('ALTER TABLE ressources ADD CONSTRAINT FK_6A2CD5C777075ABB FOREIGN KEY (camp_id) REFERENCES camp (id)');
        $this->addSql('ALTER TABLE ressources ADD CONSTRAINT FK_6A2CD5C76DC28240 FOREIGN KEY (batiments_id) REFERENCES batiments (id)');
        $this->addSql('ALTER TABLE personnage ADD lieu_actuel_id INT DEFAULT NULL, ADD camp_id INT DEFAULT NULL, ADD moral INT NOT NULL, ADD nourriture INT NOT NULL');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D66F87948 FOREIGN KEY (lieu_actuel_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D77075ABB FOREIGN KEY (camp_id) REFERENCES camp (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AEA486D66F87948 ON personnage (lieu_actuel_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AEA486D77075ABB ON personnage (camp_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ressources DROP FOREIGN KEY FK_6A2CD5C76DC28240');
        $this->addSql('ALTER TABLE batiments DROP FOREIGN KEY FK_124D799077075ABB');
        $this->addSql('ALTER TABLE batiments DROP FOREIGN KEY FK_124D79903DDF70AB');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486D77075ABB');
        $this->addSql('ALTER TABLE ressources DROP FOREIGN KEY FK_6A2CD5C777075ABB');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486D66F87948');
        $this->addSql('DROP TABLE batiments');
        $this->addSql('DROP TABLE camp');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE ressources');
        $this->addSql('DROP INDEX UNIQ_6AEA486D66F87948 ON personnage');
        $this->addSql('DROP INDEX UNIQ_6AEA486D77075ABB ON personnage');
        $this->addSql('ALTER TABLE personnage DROP lieu_actuel_id, DROP camp_id, DROP moral, DROP nourriture');
    }
}
