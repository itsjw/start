<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1505865016.
 * Generated on 2017-09-20 05:50:16 by root
 */
class PropelMigration_1505865016
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

DROP TABLE IF EXISTS "schedule" CASCADE;

DROP TABLE IF EXISTS "user_nav" CASCADE;

CREATE TABLE "nav_access"
(
    "id" serial NOT NULL,
    "nav_id" INTEGER NOT NULL,
    "user_id" INTEGER,
    "role_id" INTEGER,
    PRIMARY KEY ("id")
);

CREATE TABLE "activity_access"
(
    "id" serial NOT NULL,
    "activity_id" INTEGER NOT NULL,
    "user_id" INTEGER,
    "role_id" INTEGER,
    PRIMARY KEY ("id")
);

ALTER TABLE "nav_access" ADD CONSTRAINT "nav_access_fk_e1c7d1"
    FOREIGN KEY ("role_id")
    REFERENCES "_role" ("id")
    ON DELETE CASCADE;

ALTER TABLE "nav_access" ADD CONSTRAINT "nav_access_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id")
    ON DELETE CASCADE;

ALTER TABLE "nav_access" ADD CONSTRAINT "nav_access_fk_e124f1"
    FOREIGN KEY ("nav_id")
    REFERENCES "nav" ("id")
    ON DELETE CASCADE;

ALTER TABLE "activity_access" ADD CONSTRAINT "activity_access_fk_e1c7d1"
    FOREIGN KEY ("role_id")
    REFERENCES "_role" ("id")
    ON DELETE CASCADE;

ALTER TABLE "activity_access" ADD CONSTRAINT "activity_access_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id")
    ON DELETE CASCADE;

ALTER TABLE "activity_access" ADD CONSTRAINT "activity_access_fk_8dfe0d"
    FOREIGN KEY ("activity_id")
    REFERENCES "activity" ("id")
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

DROP TABLE IF EXISTS "nav_access" CASCADE;

DROP TABLE IF EXISTS "activity_access" CASCADE;

CREATE TABLE "schedule"
(
    "id" serial NOT NULL,
    "activity_id" INTEGER,
    "role_id" INTEGER,
    PRIMARY KEY ("id")
);

CREATE TABLE "user_nav"
(
    "nav_id" INTEGER NOT NULL,
    "user_id" INTEGER NOT NULL,
    PRIMARY KEY ("nav_id","user_id")
);

ALTER TABLE "schedule" ADD CONSTRAINT "schedule_fk_8dfe0d"
    FOREIGN KEY ("activity_id")
    REFERENCES "activity" ("id")
    ON DELETE CASCADE;

ALTER TABLE "schedule" ADD CONSTRAINT "schedule_fk_e1c7d1"
    FOREIGN KEY ("role_id")
    REFERENCES "_role" ("id")
    ON DELETE CASCADE;

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

}