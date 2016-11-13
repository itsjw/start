<?php

namespace App\Model\Map;

use App\Model\Session;
use App\Model\SessionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the '_session' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SessionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SessionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'start';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_session';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Model\\Session';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Session';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = '_session.id';

    /**
     * the column name for the token field
     */
    const COL_TOKEN = '_session.token';

    /**
     * the column name for the model_id field
     */
    const COL_MODEL_ID = '_session.model_id';

    /**
     * the column name for the model_name field
     */
    const COL_MODEL_NAME = '_session.model_name';

    /**
     * the column name for the expired_at field
     */
    const COL_EXPIRED_AT = '_session.expired_at';

    /**
     * the column name for the application_id field
     */
    const COL_APPLICATION_ID = '_session.application_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = '_session.created_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Token', 'ModelId', 'ModelName', 'ExpiredAt', 'ApplicationId', 'CreatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'token', 'modelId', 'modelName', 'expiredAt', 'applicationId', 'createdAt', ),
        self::TYPE_COLNAME       => array(SessionTableMap::COL_ID, SessionTableMap::COL_TOKEN, SessionTableMap::COL_MODEL_ID, SessionTableMap::COL_MODEL_NAME, SessionTableMap::COL_EXPIRED_AT, SessionTableMap::COL_APPLICATION_ID, SessionTableMap::COL_CREATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'token', 'model_id', 'model_name', 'expired_at', 'application_id', 'created_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Token' => 1, 'ModelId' => 2, 'ModelName' => 3, 'ExpiredAt' => 4, 'ApplicationId' => 5, 'CreatedAt' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'token' => 1, 'modelId' => 2, 'modelName' => 3, 'expiredAt' => 4, 'applicationId' => 5, 'createdAt' => 6, ),
        self::TYPE_COLNAME       => array(SessionTableMap::COL_ID => 0, SessionTableMap::COL_TOKEN => 1, SessionTableMap::COL_MODEL_ID => 2, SessionTableMap::COL_MODEL_NAME => 3, SessionTableMap::COL_EXPIRED_AT => 4, SessionTableMap::COL_APPLICATION_ID => 5, SessionTableMap::COL_CREATED_AT => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'token' => 1, 'model_id' => 2, 'model_name' => 3, 'expired_at' => 4, 'application_id' => 5, 'created_at' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('_session');
        $this->setPhpName('Session');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Model\\Session');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('_session_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('token', 'Token', 'VARCHAR', true, 255, null);
        $this->addColumn('model_id', 'ModelId', 'INTEGER', false, null, null);
        $this->addColumn('model_name', 'ModelName', 'VARCHAR', false, 255, null);
        $this->addColumn('expired_at', 'ExpiredAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('application_id', 'ApplicationId', 'INTEGER', '_application', 'id', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Application', '\\App\\Model\\Application', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':application_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'true', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SessionTableMap::CLASS_DEFAULT : SessionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Session object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SessionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SessionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SessionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SessionTableMap::OM_CLASS;
            /** @var Session $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SessionTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SessionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SessionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Session $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SessionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SessionTableMap::COL_ID);
            $criteria->addSelectColumn(SessionTableMap::COL_TOKEN);
            $criteria->addSelectColumn(SessionTableMap::COL_MODEL_ID);
            $criteria->addSelectColumn(SessionTableMap::COL_MODEL_NAME);
            $criteria->addSelectColumn(SessionTableMap::COL_EXPIRED_AT);
            $criteria->addSelectColumn(SessionTableMap::COL_APPLICATION_ID);
            $criteria->addSelectColumn(SessionTableMap::COL_CREATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.token');
            $criteria->addSelectColumn($alias . '.model_id');
            $criteria->addSelectColumn($alias . '.model_name');
            $criteria->addSelectColumn($alias . '.expired_at');
            $criteria->addSelectColumn($alias . '.application_id');
            $criteria->addSelectColumn($alias . '.created_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SessionTableMap::DATABASE_NAME)->getTable(SessionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SessionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SessionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SessionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Session or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Session object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SessionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Model\Session) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SessionTableMap::DATABASE_NAME);
            $criteria->add(SessionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SessionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SessionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SessionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _session table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SessionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Session or Criteria object.
     *
     * @param mixed               $criteria Criteria or Session object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SessionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Session object
        }

        if ($criteria->containsKey(SessionTableMap::COL_ID) && $criteria->keyContainsValue(SessionTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SessionTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SessionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SessionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SessionTableMap::buildTableMap();