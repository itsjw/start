<?php

namespace Perfumerlabs\Start\Model\Map;

use Perfumerlabs\Start\Model\Duty;
use Perfumerlabs\Start\Model\DutyQuery;
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
 * This class defines the structure of the 'duty' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DutyTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DutyTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'start';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'duty';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Perfumerlabs\\Start\\Model\\Duty';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Duty';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the id field
     */
    const COL_ID = 'duty.id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'duty.user_id';

    /**
     * the column name for the activity_id field
     */
    const COL_ACTIVITY_ID = 'duty.activity_id';

    /**
     * the column name for the priority field
     */
    const COL_PRIORITY = 'duty.priority';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'duty.title';

    /**
     * the column name for the data field
     */
    const COL_DATA = 'duty.data';

    /**
     * the column name for the raised_at field
     */
    const COL_RAISED_AT = 'duty.raised_at';

    /**
     * the column name for the picked_at field
     */
    const COL_PICKED_AT = 'duty.picked_at';

    /**
     * the column name for the closed_at field
     */
    const COL_CLOSED_AT = 'duty.closed_at';

    /**
     * the column name for the tags field
     */
    const COL_TAGS = 'duty.tags';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'duty.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'duty.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'ActivityId', 'Priority', 'Title', 'Data', 'RaisedAt', 'PickedAt', 'ClosedAt', 'Tags', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'userId', 'activityId', 'priority', 'title', 'data', 'raisedAt', 'pickedAt', 'closedAt', 'tags', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(DutyTableMap::COL_ID, DutyTableMap::COL_USER_ID, DutyTableMap::COL_ACTIVITY_ID, DutyTableMap::COL_PRIORITY, DutyTableMap::COL_TITLE, DutyTableMap::COL_DATA, DutyTableMap::COL_RAISED_AT, DutyTableMap::COL_PICKED_AT, DutyTableMap::COL_CLOSED_AT, DutyTableMap::COL_TAGS, DutyTableMap::COL_CREATED_AT, DutyTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'activity_id', 'priority', 'title', 'data', 'raised_at', 'picked_at', 'closed_at', 'tags', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'ActivityId' => 2, 'Priority' => 3, 'Title' => 4, 'Data' => 5, 'RaisedAt' => 6, 'PickedAt' => 7, 'ClosedAt' => 8, 'Tags' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'userId' => 1, 'activityId' => 2, 'priority' => 3, 'title' => 4, 'data' => 5, 'raisedAt' => 6, 'pickedAt' => 7, 'closedAt' => 8, 'tags' => 9, 'createdAt' => 10, 'updatedAt' => 11, ),
        self::TYPE_COLNAME       => array(DutyTableMap::COL_ID => 0, DutyTableMap::COL_USER_ID => 1, DutyTableMap::COL_ACTIVITY_ID => 2, DutyTableMap::COL_PRIORITY => 3, DutyTableMap::COL_TITLE => 4, DutyTableMap::COL_DATA => 5, DutyTableMap::COL_RAISED_AT => 6, DutyTableMap::COL_PICKED_AT => 7, DutyTableMap::COL_CLOSED_AT => 8, DutyTableMap::COL_TAGS => 9, DutyTableMap::COL_CREATED_AT => 10, DutyTableMap::COL_UPDATED_AT => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'activity_id' => 2, 'priority' => 3, 'title' => 4, 'data' => 5, 'raised_at' => 6, 'picked_at' => 7, 'closed_at' => 8, 'tags' => 9, 'created_at' => 10, 'updated_at' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $this->setName('duty');
        $this->setPhpName('Duty');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Perfumerlabs\\Start\\Model\\Duty');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('duty_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('user_id', 'UserId', 'INTEGER', false, null, null);
        $this->addForeignKey('activity_id', 'ActivityId', 'INTEGER', 'activity', 'id', false, null, null);
        $this->addColumn('priority', 'Priority', 'INTEGER', false, null, null);
        $this->addColumn('title', 'Title', 'LONGVARCHAR', false, null, null);
        $this->addColumn('data', 'Data', 'LONGVARCHAR', false, null, null);
        $this->addColumn('raised_at', 'RaisedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('picked_at', 'PickedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('closed_at', 'ClosedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('tags', 'Tags', 'ARRAY', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Activity', '\\Perfumerlabs\\Start\\Model\\Activity', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':activity_id',
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
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
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
        return $withPrefix ? DutyTableMap::CLASS_DEFAULT : DutyTableMap::OM_CLASS;
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
     * @return array           (Duty object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DutyTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DutyTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DutyTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DutyTableMap::OM_CLASS;
            /** @var Duty $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DutyTableMap::addInstanceToPool($obj, $key);
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
            $key = DutyTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DutyTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Duty $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DutyTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DutyTableMap::COL_ID);
            $criteria->addSelectColumn(DutyTableMap::COL_USER_ID);
            $criteria->addSelectColumn(DutyTableMap::COL_ACTIVITY_ID);
            $criteria->addSelectColumn(DutyTableMap::COL_PRIORITY);
            $criteria->addSelectColumn(DutyTableMap::COL_TITLE);
            $criteria->addSelectColumn(DutyTableMap::COL_DATA);
            $criteria->addSelectColumn(DutyTableMap::COL_RAISED_AT);
            $criteria->addSelectColumn(DutyTableMap::COL_PICKED_AT);
            $criteria->addSelectColumn(DutyTableMap::COL_CLOSED_AT);
            $criteria->addSelectColumn(DutyTableMap::COL_TAGS);
            $criteria->addSelectColumn(DutyTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(DutyTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.activity_id');
            $criteria->addSelectColumn($alias . '.priority');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.data');
            $criteria->addSelectColumn($alias . '.raised_at');
            $criteria->addSelectColumn($alias . '.picked_at');
            $criteria->addSelectColumn($alias . '.closed_at');
            $criteria->addSelectColumn($alias . '.tags');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
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
        return Propel::getServiceContainer()->getDatabaseMap(DutyTableMap::DATABASE_NAME)->getTable(DutyTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DutyTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DutyTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DutyTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Duty or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Duty object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DutyTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Perfumerlabs\Start\Model\Duty) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DutyTableMap::DATABASE_NAME);
            $criteria->add(DutyTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DutyQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DutyTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DutyTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the duty table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DutyQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Duty or Criteria object.
     *
     * @param mixed               $criteria Criteria or Duty object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DutyTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Duty object
        }

        if ($criteria->containsKey(DutyTableMap::COL_ID) && $criteria->keyContainsValue(DutyTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DutyTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DutyQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DutyTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DutyTableMap::buildTableMap();
