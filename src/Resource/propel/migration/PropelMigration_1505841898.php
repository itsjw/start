<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1505841898.
 * Generated on 2017-09-19 23:24:58 by root
 */
class PropelMigration_1505841898
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

ALTER TABLE "duty" ADD CONSTRAINT "duty_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id");

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

ALTER TABLE "duty" DROP CONSTRAINT "duty_fk_5804d8";

COMMIT;
',
);
    }

}