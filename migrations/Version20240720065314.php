<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720065314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Añade un usuario al la base de datos';
    }

    public function up(Schema $schema): void
    {
        $password =  '$2y$13$fg0LRbGrrnLBdgOuUEOPAutURAmr2duNaerwZ5SrALqn12SnlpgZK';
        $this->addSql("INSERT INTO `user` ( `username`, `roles`, `password`, `foto`) VALUES ('admin', '[\"ROLE_USER\"]', '$password', '')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
