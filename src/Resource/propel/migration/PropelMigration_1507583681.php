<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1507583681.
 * Generated on 2017-10-09 21:14:41 by root
 */
class PropelMigration_1507583681
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'start' => '
BEGIN;

CREATE TABLE "tag"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "tag_u_d94269" UNIQUE ("name")
);

CREATE TABLE "related_tag"
(
    "duty_id" INTEGER NOT NULL,
    "tag_id" INTEGER NOT NULL,
    PRIMARY KEY ("duty_id","tag_id")
);

ALTER TABLE "related_tag" ADD CONSTRAINT "related_tag_fk_3f140d"
    FOREIGN KEY ("duty_id")
    REFERENCES "duty" ("id")
    ON DELETE CASCADE;

ALTER TABLE "related_tag" ADD CONSTRAINT "related_tag_fk_022a95"
    FOREIGN KEY ("tag_id")
    REFERENCES "tag" ("id")
    ON DELETE CASCADE;

COMMIT;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'start' => '
BEGIN;

DROP TABLE IF EXISTS "tag" CASCADE;

DROP TABLE IF EXISTS "related_tag" CASCADE;

COMMIT;
',
);
    }

}