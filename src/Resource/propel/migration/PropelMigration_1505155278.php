<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1505155278.
 * Generated on 2017-09-12 00:41:18 by root
 */
class PropelMigration_1505155278
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

ALTER TABLE "_user" RENAME COLUMN "banned_till" TO "online_at";

ALTER TABLE "schedule" RENAME COLUMN "user_id" TO "activity_id";

ALTER TABLE "schedule"

  DROP COLUMN "activities",

  DROP COLUMN "week_day",

  DROP COLUMN "_date",

  DROP COLUMN "time_from",

  DROP COLUMN "time_to";

ALTER TABLE "schedule" ADD CONSTRAINT "schedule_fk_e1c7d1"
    FOREIGN KEY ("role_id")
    REFERENCES "_role" ("id")
    ON DELETE CASCADE;

ALTER TABLE "schedule" ADD CONSTRAINT "schedule_fk_8dfe0d"
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

ALTER TABLE "_user" RENAME COLUMN "online_at" TO "banned_till";

ALTER TABLE "schedule" DROP CONSTRAINT "schedule_fk_e1c7d1";

ALTER TABLE "schedule" DROP CONSTRAINT "schedule_fk_8dfe0d";

ALTER TABLE "schedule" RENAME COLUMN "activity_id" TO "user_id";

ALTER TABLE "schedule"

  ADD "activities" TEXT,

  ADD "week_day" INTEGER,

  ADD "_date" DATE,

  ADD "time_from" TIME,

  ADD "time_to" TIME;

COMMIT;
',
);
    }

}