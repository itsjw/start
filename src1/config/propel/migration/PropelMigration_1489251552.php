<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1489251552.
 * Generated on 2017-03-11 16:59:12 by root
 */
class PropelMigration_1489251552
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

ALTER TABLE "activity"

  ADD "writable" BOOLEAN DEFAULT \'f\' NOT NULL,

  ADD "priority" INTEGER;

ALTER TABLE "duty"

  DROP COLUMN "priority";

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

ALTER TABLE "activity"

  DROP COLUMN "writable",

  DROP COLUMN "priority";

ALTER TABLE "duty"

  ADD "priority" INTEGER;

COMMIT;
',
);
    }

}