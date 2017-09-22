<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1506041847.
 * Generated on 2017-09-22 06:57:27 by root
 */
class PropelMigration_1506041847
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

  ADD "key" VARCHAR(255);

ALTER TABLE "duty"

  ADD "code" VARCHAR(255);

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

  DROP COLUMN "key";

ALTER TABLE "duty"

  DROP COLUMN "code";

COMMIT;
',
);
    }

}