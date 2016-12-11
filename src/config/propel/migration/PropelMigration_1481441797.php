<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1481441797.
 * Generated on 2016-12-11 07:36:37 by root
 */
class PropelMigration_1481441797
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
ALTER TABLE "activity" DROP CONSTRAINT "activity_fk_5804d8";

ALTER TABLE "schedule" DROP CONSTRAINT "schedule_fk_5804d8";

ALTER TABLE "schedule" DROP CONSTRAINT "schedule_fk_e1c7d1";
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
ALTER TABLE "activity" ADD CONSTRAINT "activity_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id");

ALTER TABLE "schedule" ADD CONSTRAINT "schedule_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id");

ALTER TABLE "schedule" ADD CONSTRAINT "schedule_fk_e1c7d1"
    FOREIGN KEY ("role_id")
    REFERENCES "_role" ("id");
',
);
    }

}