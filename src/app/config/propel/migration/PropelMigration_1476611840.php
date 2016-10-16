<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1476611840.
 * Generated on 2016-10-16 09:57:20 by root
 */
class PropelMigration_1476611840
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
DROP TABLE IF EXISTS "fragment" CASCADE;

CREATE TABLE "activity"
(
    "id" serial NOT NULL,
    "user_id" INTEGER,
    "code" INTEGER,
    "title" TEXT,
    "data" TEXT,
    "closed_at" TIMESTAMP,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

ALTER TABLE "activity" ADD CONSTRAINT "activity_fk_5804d8"
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
DROP TABLE IF EXISTS "activity" CASCADE;

CREATE TABLE "fragment"
(
    "id" serial NOT NULL,
    "user_id" INTEGER,
    "data" TEXT,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    "tile" VARCHAR,
    "title" TEXT,
    "closed_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

ALTER TABLE "fragment" ADD CONSTRAINT "fragment_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id");
',
);
    }

}