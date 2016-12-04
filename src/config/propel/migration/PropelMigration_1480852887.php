<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1480852887.
 * Generated on 2016-12-04 12:01:27 by root
 */
class PropelMigration_1480852887
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

  ADD "name" VARCHAR(255),

  DROP COLUMN "code";
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

  ADD "code" INTEGER,

  DROP COLUMN "name";
',
);
    }

}