<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1505945563.
 * Generated on 2017-09-21 04:12:43 by root
 */
class PropelMigration_1505945563
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

CREATE TABLE "vendor"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255),
    "hostname" VARCHAR(255),
    PRIMARY KEY ("id")
);

ALTER TABLE "activity"

  ADD "vendor_id" INTEGER,

  DROP COLUMN "iframe",

  DROP COLUMN "toolbar";

ALTER TABLE "activity" ADD CONSTRAINT "activity_fk_b4057b"
    FOREIGN KEY ("vendor_id")
    REFERENCES "vendor" ("id");

ALTER TABLE "duty" RENAME COLUMN "query" TO "iframe_url";

ALTER TABLE "duty"

  ALTER COLUMN "validation_url" TYPE TEXT USING NULL;

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

DROP TABLE IF EXISTS "vendor" CASCADE;

ALTER TABLE "activity" DROP CONSTRAINT "activity_fk_b4057b";

ALTER TABLE "activity"

  ADD "iframe" VARCHAR(255),

  ADD "toolbar" VARCHAR(255),

  DROP COLUMN "vendor_id";

ALTER TABLE "duty" RENAME COLUMN "iframe_url" TO "query";

ALTER TABLE "duty"

  ALTER COLUMN "validation_url" TYPE VARCHAR(255) USING NULL;

COMMIT;
',
);
    }

}