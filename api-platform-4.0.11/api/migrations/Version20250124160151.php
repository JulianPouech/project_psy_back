<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250124160151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patients (
            id SERIAL,
            first_name VARCHAR(128) NOT NULL,
            last_name VARCHAR(128) NOT NULL,
            phone VARCHAR(16) NOT NULL,
            PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users_patients (
            user_id INT NOT NULL,
            patient_id INT NOT NULL,
            PRIMARY KEY(user_id, patient_id),
            CONSTRAINT fk_user
                FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
            CONSTRAINT fk_patient
                FOREIGN KEY (patient_id) REFERENCES patients (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_patients');
        $this->addSql('DROP TABLE patient');
    }
}
