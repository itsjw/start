<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1474192277.
 * Generated on 2016-09-18 09:51:17 by root
 */
class PropelMigration_1474192277
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
CREATE TABLE "fragment"
(
    "id" serial NOT NULL,
    "user_id" INTEGER,
    "uri" TEXT,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

CREATE TABLE "_application"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "token" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "_role"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "permission" VARCHAR(255),
    PRIMARY KEY ("id")
);

CREATE TABLE "_resource"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "value" TEXT NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "_resource_u_d94269" UNIQUE ("name")
);

CREATE TABLE "_session"
(
    "id" serial NOT NULL,
    "token" VARCHAR(255) NOT NULL,
    "model_id" INTEGER,
    "model_name" VARCHAR(255),
    "expired_at" TIMESTAMP,
    "application_id" INTEGER,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id"),
    CONSTRAINT "_session_u_5541c6" UNIQUE ("token")
);

CREATE INDEX "_session_i_a27ab5" ON "_session" ("model_id","model_name");

CREATE INDEX "_session_i_3b06ab" ON "_session" ("expired_at");

CREATE TABLE "_user"
(
    "id" serial NOT NULL,
    "username" VARCHAR(255) NOT NULL,
    "password" VARCHAR(255),
    "is_admin" BOOLEAN DEFAULT \'f\' NOT NULL,
    "is_disabled" BOOLEAN DEFAULT \'f\' NOT NULL,
    "banned_till" TIMESTAMP,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id"),
    CONSTRAINT "_user_u_f86ef3" UNIQUE ("username")
);

CREATE TABLE "_user_role"
(
    "user_id" INTEGER NOT NULL,
    "role_id" INTEGER NOT NULL,
    PRIMARY KEY ("user_id","role_id")
);

ALTER TABLE "_session" ADD CONSTRAINT "_session_fk_0a251d"
    FOREIGN KEY ("application_id")
    REFERENCES "_application" ("id");

ALTER TABLE "_user_role" ADD CONSTRAINT "_user_role_fk_5804d8"
    FOREIGN KEY ("user_id")
    REFERENCES "_user" ("id")
    ON DELETE CASCADE;

ALTER TABLE "_user_role" ADD CONSTRAINT "_user_role_fk_e1c7d1"
    FOREIGN KEY ("role_id")
    REFERENCES "_role" ("id")
    ON DELETE CASCADE;
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
DROP TABLE IF EXISTS "fragment" CASCADE;

DROP TABLE IF EXISTS "_application" CASCADE;

DROP TABLE IF EXISTS "_role" CASCADE;

DROP TABLE IF EXISTS "_resource" CASCADE;

DROP TABLE IF EXISTS "_session" CASCADE;

DROP TABLE IF EXISTS "_user" CASCADE;

DROP TABLE IF EXISTS "_user_role" CASCADE;
',
);
    }

}