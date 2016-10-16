<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1476614297.
 * Generated on 2016-10-16 10:38:17 by root
 */
class PropelMigration_1476614297
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
ALTER TABLE "activity"

  ADD "raised_at" TIMESTAMP,

  ADD "picked_at" TIMESTAMP;
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
ALTER TABLE "activity"

  DROP COLUMN "raised_at",

  DROP COLUMN "picked_at";
',
);
    }

}