<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251020195504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_restaurant (booking_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_720F714E3301C60 (booking_id), INDEX IDX_720F714EB1E7706E (restaurant_id), PRIMARY KEY(booking_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_restaurant ADD CONSTRAINT FK_720F714E3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_restaurant ADD CONSTRAINT FK_720F714EB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_restaurant DROP FOREIGN KEY FK_720F714E3301C60');
        $this->addSql('ALTER TABLE booking_restaurant DROP FOREIGN KEY FK_720F714EB1E7706E');
        $this->addSql('DROP TABLE booking_restaurant');
    }
}
