<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1474795678.
 * Generated on 2016-09-25 09:27:58 by root
 */
class PropelMigration_1474795678
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
ALTER TABLE "fragment" RENAME COLUMN "uri" TO "data";

ALTER TABLE "fragment"

  ADD "tile" VARCHAR,

  DROP COLUMN "title";
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
ALTER TABLE "fragment" RENAME COLUMN "data" TO "uri";

ALTER TABLE "fragment"

  ADD "title" TEXT,

  DROP COLUMN "tile";
',
);
    }

}