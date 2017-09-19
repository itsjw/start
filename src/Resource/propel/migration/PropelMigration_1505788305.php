<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1505788305.
 * Generated on 2017-09-19 08:31:45 by root
 */
class PropelMigration_1505788305
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

CREATE TABLE "nav"
(
    "id" serial NOT NULL,
    "activity_id" INTEGER,
    "name" VARCHAR(255) NOT NULL,
    "link" TEXT,
    "priority" INTEGER NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "user_nav"
(
    "nav_id" INTEGER NOT NULL,
    "user_id" INTEGER NOT NULL,
    PRIMARY KEY ("nav_id","user_id")
);

ALTER TABLE "nav" ADD CONSTRAINT "nav_fk_8dfe0d"
    FOREIGN KEY ("activity_id")
    REFERENCES "activity" ("id");

ALTER TABLE "user_nav" ADD CONSTRAINT "user_nav_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id")
    ON DELETE CASCADE;

ALTER TABLE "user_nav" ADD CONSTRAINT "user_nav_fk_e124f1"
    FOREIGN KEY ("nav_id")
    REFERENCES "nav" ("id")
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

DROP TABLE IF EXISTS "nav" CASCADE;

DROP TABLE IF EXISTS "user_nav" CASCADE;

COMMIT;
',
);
    }

}