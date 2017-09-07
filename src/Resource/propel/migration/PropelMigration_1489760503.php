<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1489760503.
 * Generated on 2017-03-17 14:21:43 by root
 */
class PropelMigration_1489760503
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

ALTER TABLE "_session" DROP CONSTRAINT "_session_fk_0a251d";

DROP INDEX "_session_i_a27ab5";

ALTER TABLE "_session" RENAME COLUMN "model_id" TO "user_id";


ALTER TABLE "_session" RENAME COLUMN "model_name" TO "data";

ALTER TABLE "_session"

  DROP COLUMN "application_id";

CREATE INDEX "_session_i_6ca017" ON "_session" ("user_id");

ALTER TABLE "_session" ADD CONSTRAINT "_session_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id");

DROP TABLE IF EXISTS "_application" CASCADE;

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

CREATE TABLE "_application"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "token" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id")
);

ALTER TABLE "_session" DROP CONSTRAINT "_session_fk_5804d8";

DROP INDEX "_session_i_6ca017";

ALTER TABLE "_session" RENAME COLUMN "user_id" TO "model_id";


ALTER TABLE "_session" RENAME COLUMN "data" TO "model_name";

ALTER TABLE "_session"

  ADD "application_id" INTEGER;

CREATE INDEX "_session_i_a27ab5" ON "_session" ("model_id","model_name");

ALTER TABLE "_session" ADD CONSTRAINT "_session_fk_0a251d"
    FOREIGN KEY ("application_id")
    REFERENCES "_application" ("id");

COMMIT;
',
);
    }

}