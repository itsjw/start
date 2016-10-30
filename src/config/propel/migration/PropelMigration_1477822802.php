<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1477822802.
 * Generated on 2016-10-30 10:20:02 by root
 */
class PropelMigration_1477822802
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
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
CREATE TABLE "schedule"
(
    "id" serial NOT NULL,
    "user_id" INTEGER,
    "role_id" INTEGER,
    "activity_codes" TEXT,
    "week_day" INTEGER,
    "_date" DATE,
    "time_from" TIME,
    "time_to" TIME,
    PRIMARY KEY ("id")
);

ALTER TABLE "_role"

  DROP COLUMN "activity_codes";

ALTER TABLE "schedule" ADD CONSTRAINT "schedule_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id");

ALTER TABLE "schedule" ADD CONSTRAINT "schedule_fk_e1c7d1"
    FOREIGN KEY ("role_id")
    REFERENCES "_role" ("id");
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
DROP TABLE IF EXISTS "schedule" CASCADE;

ALTER TABLE "_role"

  ADD "activity_codes" TEXT;
',
);
    }

}