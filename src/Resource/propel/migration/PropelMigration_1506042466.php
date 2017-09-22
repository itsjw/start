<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1506042466.
 * Generated on 2017-09-22 07:07:46 by root
 */
class PropelMigration_1506042466
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

ALTER TABLE "activity" RENAME COLUMN "readonly" TO "closing";


ALTER TABLE "activity" RENAME COLUMN "writable" TO "commenting";


ALTER TABLE "activity" RENAME COLUMN "postponable" TO "postponing";

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

ALTER TABLE "activity" RENAME COLUMN "closing" TO "readonly";


ALTER TABLE "activity" RENAME COLUMN "commenting" TO "writable";


ALTER TABLE "activity" RENAME COLUMN "postponing" TO "postponable";

COMMIT;
',
);
    }

}