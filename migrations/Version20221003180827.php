<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003180827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_58DF06519D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `grant` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, city VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_312B3E169D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, partner_id_id INT NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_6F0137EA9D86650F (user_id_id), INDEX IDX_6F0137EA6C783232 (partner_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_grants (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, grant_id_id INT NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_1FFDCEB9D86650F (user_id_id), INDEX IDX_1FFDCEB323467CC (grant_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF06519D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E169D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA6C783232 FOREIGN KEY (partner_id_id) REFERENCES partner (id)');
        $this->addSql('ALTER TABLE user_grants ADD CONSTRAINT FK_1FFDCEB9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_grants ADD CONSTRAINT FK_1FFDCEB323467CC FOREIGN KEY (grant_id_id) REFERENCES `grant` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF06519D86650F');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E169D86650F');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA9D86650F');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA6C783232');
        $this->addSql('ALTER TABLE user_grants DROP FOREIGN KEY FK_1FFDCEB9D86650F');
        $this->addSql('ALTER TABLE user_grants DROP FOREIGN KEY FK_1FFDCEB323467CC');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE `grant`');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE user_grants');
    }
}
