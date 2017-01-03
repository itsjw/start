<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1483438024.
 * Generated on 2017-01-03 10:07:04 by root
 */
class PropelMigration_1483438024
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

  DROP COLUMN "amd";

ALTER TABLE "duty"

  DROP COLUMN "data";
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

  ADD "amd" VARCHAR(255);

ALTER TABLE "duty"

  ADD "data" TEXT;
',
);
    }

}