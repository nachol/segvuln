<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171216180852 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_A0FE8A1E53C59D72');
        $this->addSql('CREATE TEMPORARY TABLE __temp__plataforma AS SELECT id, responsable_id, descripcion, ubicacion FROM plataforma');
        $this->addSql('DROP TABLE plataforma');
        $this->addSql('CREATE TABLE plataforma (id INTEGER NOT NULL, responsable_id INTEGER DEFAULT NULL, descripcion VARCHAR(255) NOT NULL COLLATE BINARY, ubicacion VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_A0FE8A1E53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO plataforma (id, responsable_id, descripcion, ubicacion) SELECT id, responsable_id, descripcion, ubicacion FROM __temp__plataforma');
        $this->addSql('DROP TABLE __temp__plataforma');
        $this->addSql('CREATE INDEX IDX_A0FE8A1E53C59D72 ON plataforma (responsable_id)');
        $this->addSql('DROP INDEX IDX_EE34EB96A9276E6C');
        $this->addSql('DROP INDEX IDX_EE34EB96F7A6D53B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__vulnerabilidad AS SELECT id, tipo_id, escaneo_id, estado, fecha_creacion, comentario, fecha_modificacion FROM vulnerabilidad');
        $this->addSql('DROP TABLE vulnerabilidad');
        $this->addSql('CREATE TABLE vulnerabilidad (id INTEGER NOT NULL, tipo_id INTEGER NOT NULL, escaneo_id INTEGER NOT NULL, estado INTEGER DEFAULT 1 NOT NULL, fecha_creacion DATETIME NOT NULL, comentario VARCHAR(255) DEFAULT NULL COLLATE BINARY, fecha_modificacion DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_EE34EB96A9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo_vuln (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EE34EB96F7A6D53B FOREIGN KEY (escaneo_id) REFERENCES escaneo (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO vulnerabilidad (id, tipo_id, escaneo_id, estado, fecha_creacion, comentario, fecha_modificacion) SELECT id, tipo_id, escaneo_id, estado, fecha_creacion, comentario, fecha_modificacion FROM __temp__vulnerabilidad');
        $this->addSql('DROP TABLE __temp__vulnerabilidad');
        $this->addSql('CREATE INDEX IDX_EE34EB96A9276E6C ON vulnerabilidad (tipo_id)');
        $this->addSql('CREATE INDEX IDX_EE34EB96F7A6D53B ON vulnerabilidad (escaneo_id)');
        $this->addSql('DROP INDEX IDX_13925BA9A9276E6C');
        $this->addSql('DROP INDEX IDX_13925BA9EB90E430');
        $this->addSql('CREATE TEMPORARY TABLE __temp__escaneo AS SELECT id, tipo_id, plataforma_id, fecha, descripcion, informe FROM escaneo');
        $this->addSql('DROP TABLE escaneo');
        $this->addSql('CREATE TABLE escaneo (id INTEGER NOT NULL, tipo_id INTEGER NOT NULL, plataforma_id INTEGER NOT NULL, fecha DATETIME NOT NULL, descripcion VARCHAR(255) DEFAULT NULL COLLATE BINARY, informe VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_13925BA9A9276E6C FOREIGN KEY (tipo_id) REFERENCES tipo_escaneo (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_13925BA9EB90E430 FOREIGN KEY (plataforma_id) REFERENCES plataforma (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO escaneo (id, tipo_id, plataforma_id, fecha, descripcion, informe) SELECT id, tipo_id, plataforma_id, fecha, descripcion, informe FROM __temp__escaneo');
        $this->addSql('DROP TABLE __temp__escaneo');
        $this->addSql('CREATE INDEX IDX_13925BA9A9276E6C ON escaneo (tipo_id)');
        $this->addSql('CREATE INDEX IDX_13925BA9EB90E430 ON escaneo (plataforma_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_13925BA9A9276E6C');
        $this->addSql('DROP INDEX IDX_13925BA9EB90E430');
        $this->addSql('CREATE TEMPORARY TABLE __temp__escaneo AS SELECT id, tipo_id, plataforma_id, fecha, descripcion, informe FROM escaneo');
        $this->addSql('DROP TABLE escaneo');
        $this->addSql('CREATE TABLE escaneo (id INTEGER NOT NULL, tipo_id INTEGER NOT NULL, plataforma_id INTEGER NOT NULL, fecha DATETIME NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, informe VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO escaneo (id, tipo_id, plataforma_id, fecha, descripcion, informe) SELECT id, tipo_id, plataforma_id, fecha, descripcion, informe FROM __temp__escaneo');
        $this->addSql('DROP TABLE __temp__escaneo');
        $this->addSql('CREATE INDEX IDX_13925BA9A9276E6C ON escaneo (tipo_id)');
        $this->addSql('CREATE INDEX IDX_13925BA9EB90E430 ON escaneo (plataforma_id)');
        $this->addSql('DROP INDEX IDX_A0FE8A1E53C59D72');
        $this->addSql('CREATE TEMPORARY TABLE __temp__plataforma AS SELECT id, responsable_id, descripcion, ubicacion FROM plataforma');
        $this->addSql('DROP TABLE plataforma');
        $this->addSql('CREATE TABLE plataforma (id INTEGER NOT NULL, responsable_id INTEGER DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, ubicacion VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO plataforma (id, responsable_id, descripcion, ubicacion) SELECT id, responsable_id, descripcion, ubicacion FROM __temp__plataforma');
        $this->addSql('DROP TABLE __temp__plataforma');
        $this->addSql('CREATE INDEX IDX_A0FE8A1E53C59D72 ON plataforma (responsable_id)');
        $this->addSql('DROP INDEX IDX_EE34EB96A9276E6C');
        $this->addSql('DROP INDEX IDX_EE34EB96F7A6D53B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__vulnerabilidad AS SELECT id, tipo_id, escaneo_id, estado, fecha_creacion, fecha_modificacion, comentario FROM vulnerabilidad');
        $this->addSql('DROP TABLE vulnerabilidad');
        $this->addSql('CREATE TABLE vulnerabilidad (id INTEGER NOT NULL, tipo_id INTEGER NOT NULL, escaneo_id INTEGER NOT NULL, estado INTEGER DEFAULT 1 NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_modificacion DATETIME DEFAULT NULL, comentario VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO vulnerabilidad (id, tipo_id, escaneo_id, estado, fecha_creacion, fecha_modificacion, comentario) SELECT id, tipo_id, escaneo_id, estado, fecha_creacion, fecha_modificacion, comentario FROM __temp__vulnerabilidad');
        $this->addSql('DROP TABLE __temp__vulnerabilidad');
        $this->addSql('CREATE INDEX IDX_EE34EB96A9276E6C ON vulnerabilidad (tipo_id)');
        $this->addSql('CREATE INDEX IDX_EE34EB96F7A6D53B ON vulnerabilidad (escaneo_id)');
    }
}
