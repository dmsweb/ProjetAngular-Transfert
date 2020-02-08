<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205004518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot ADD user_depot_id INT NOT NULL, ADD numero_compte_id INT NOT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC659D30DE FOREIGN KEY (user_depot_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCBFD610BF FOREIGN KEY (numero_compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_47948BBC659D30DE ON depot (user_depot_id)');
        $this->addSql('CREATE INDEX IDX_47948BBCBFD610BF ON depot (numero_compte_id)');
        $this->addSql('ALTER TABLE user ADD partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64998DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64998DE13AC ON user (partenaire_id)');
        $this->addSql('ALTER TABLE transaction ADD user_transact_id INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14D451BFE FOREIGN KEY (user_transact_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_723705D14D451BFE ON transaction (user_transact_id)');
        $this->addSql('ALTER TABLE compte ADD iduser_id INT NOT NULL');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFF65260786A81FB ON compte (iduser_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260786A81FB');
        $this->addSql('DROP INDEX IDX_CFF65260786A81FB ON compte');
        $this->addSql('ALTER TABLE compte DROP iduser_id');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC659D30DE');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCBFD610BF');
        $this->addSql('DROP INDEX IDX_47948BBC659D30DE ON depot');
        $this->addSql('DROP INDEX IDX_47948BBCBFD610BF ON depot');
        $this->addSql('ALTER TABLE depot DROP user_depot_id, DROP numero_compte_id');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14D451BFE');
        $this->addSql('DROP INDEX IDX_723705D14D451BFE ON transaction');
        $this->addSql('ALTER TABLE transaction DROP user_transact_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64998DE13AC');
        $this->addSql('DROP INDEX IDX_8D93D64998DE13AC ON user');
        $this->addSql('ALTER TABLE user DROP partenaire_id');
    }
}
