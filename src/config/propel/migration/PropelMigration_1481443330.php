<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1481443330.
 * Generated on 2016-12-11 08:02:10 by root
 */
class PropelMigration_1481443330
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
CREATE TABLE "duty"
(
    "id" serial NOT NULL,
    "user_id" INTEGER,
    "activity_id" INTEGER,
    "priority" INTEGER,
    "title" TEXT,
    "data" TEXT,
    "raised_at" TIMESTAMP,
    "picked_at" TIMESTAMP,
    "closed_at" TIMESTAMP,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

ALTER TABLE "activity"

  ADD "amd" VARCHAR(255),

  ADD "iframe" VARCHAR(255),

  ADD "readonly" BOOLEAN DEFAULT \'f\' NOT NULL,

  DROP COLUMN "user_id",

  DROP COLUMN "title",

  DROP COLUMN "data",

  DROP COLUMN "closed_at",

  DROP COLUMN "created_at",

  DROP COLUMN "updated_at",

  DROP COLUMN "priority",

  DROP COLUMN "raised_at",

  DROP COLUMN "picked_at";

ALTER TABLE "duty" ADD CONSTRAINT "duty_fk_8dfe0d"
    FOREIGN KEY ("activity_id")
    REFERENCES "activity" ("id");
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
DROP TABLE IF EXISTS "duty" CASCADE;

ALTER TABLE "activity"

  ADD "user_id" INTEGER,

  ADD "title" TEXT,

  ADD "data" TEXT,

  ADD "closed_at" TIMESTAMP,

  ADD "created_at" TIMESTAMP,

  ADD "updated_at" TIMESTAMP,

  ADD "priority" INTEGER,

  ADD "raised_at" TIMESTAMP,

  ADD "picked_at" TIMESTAMP,

  DROP COLUMN "amd",

  DROP COLUMN "iframe",

  DROP COLUMN "readonly";
',
);
    }

}