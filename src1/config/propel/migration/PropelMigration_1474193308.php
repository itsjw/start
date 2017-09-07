<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1474193308.
 * Generated on 2016-09-18 10:08:28 by root
 */
class PropelMigration_1474193308
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
ALTER TABLE "fragment" ADD CONSTRAINT "fragment_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id");
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
ALTER TABLE "fragment" DROP CONSTRAINT "fragment_fk_5804d8";
',
);
    }

}