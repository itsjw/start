<?php

namespace Perfumerlabs\Start\Model\Map;

use Perfumerlabs\Start\Model\Activity;
use Perfumerlabs\Start\Model\ActivityQuery;
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
 * This class defines the structure of the 'activity' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ActivityTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ActivityTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'start';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'activity';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Perfumerlabs\\Start\\Model\\Activity';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Activity';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'activity.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'activity.name';

    /**
     * the column name for the iframe field
     */
    const COL_IFRAME = 'activity.iframe';

    /**
     * the column name for the readonly field
     */
    const COL_READONLY = 'activity.readonly';

    /**
     * the column name for the writable field
     */
    const COL_WRITABLE = 'activity.writable';

    /**
     * the column name for the postponable field
     */
    const COL_POSTPONABLE = 'activity.postponable';

    /**
     * the column name for the color field
     */
    const COL_COLOR = 'activity.color';

    /**
     * the column name for the toolbar field
     */
    const COL_TOOLBAR = 'activity.toolbar';

    /**
     * the column name for the priority field
     */
    const COL_PRIORITY = 'activity.priority';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Iframe', 'Readonly', 'Writable', 'Postponable', 'Color', 'Toolbar', 'Priority', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'iframe', 'readonly', 'writable', 'postponable', 'color', 'toolbar', 'priority', ),
        self::TYPE_COLNAME       => array(ActivityTableMap::COL_ID, ActivityTableMap::COL_NAME, ActivityTableMap::COL_IFRAME, ActivityTableMap::COL_READONLY, ActivityTableMap::COL_WRITABLE, ActivityTableMap::COL_POSTPONABLE, ActivityTableMap::COL_COLOR, ActivityTableMap::COL_TOOLBAR, ActivityTableMap::COL_PRIORITY, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'iframe', 'readonly', 'writable', 'postponable', 'color', 'toolbar', 'priority', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Iframe' => 2, 'Readonly' => 3, 'Writable' => 4, 'Postponable' => 5, 'Color' => 6, 'Toolbar' => 7, 'Priority' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'iframe' => 2, 'readonly' => 3, 'writable' => 4, 'postponable' => 5, 'color' => 6, 'toolbar' => 7, 'priority' => 8, ),
        self::TYPE_COLNAME       => array(ActivityTableMap::COL_ID => 0, ActivityTableMap::COL_NAME => 1, ActivityTableMap::COL_IFRAME => 2, ActivityTableMap::COL_READONLY => 3, ActivityTableMap::COL_WRITABLE => 4, ActivityTableMap::COL_POSTPONABLE => 5, ActivityTableMap::COL_COLOR => 6, ActivityTableMap::COL_TOOLBAR => 7, ActivityTableMap::COL_PRIORITY => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'iframe' => 2, 'readonly' => 3, 'writable' => 4, 'postponable' => 5, 'color' => 6, 'toolbar' => 7, 'priority' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('activity');
        $this->setPhpName('Activity');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Perfumerlabs\\Start\\Model\\Activity');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('activity_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('iframe', 'Iframe', 'VARCHAR', false, 255, null);
        $this->addColumn('readonly', 'Readonly', 'BOOLEAN', true, null, false);
        $this->addColumn('writable', 'Writable', 'BOOLEAN', true, null, false);
        $this->addColumn('postponable', 'Postponable', 'BOOLEAN', true, null, false);
        $this->addColumn('color', 'Color', 'VARCHAR', false, 255, null);
        $this->addColumn('toolbar', 'Toolbar', 'VARCHAR', false, 255, null);
        $this->addColumn('priority', 'Priority', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Duty', '\\Perfumerlabs\\Start\\Model\\Duty', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':activity_id',
    1 => ':id',
  ),
), null, null, 'Duties', false);
    } // buildRelations()

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

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return $withPrefix ? ActivityTableMap::CLASS_DEFAULT : ActivityTableMap::OM_CLASS;
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
     * @return array           (Activity object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ActivityTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ActivityTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ActivityTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ActivityTableMap::OM_CLASS;
            /** @var Activity $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ActivityTableMap::addInstanceToPool($obj, $key);
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
            $key = ActivityTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ActivityTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Activity $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ActivityTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ActivityTableMap::COL_ID);
            $criteria->addSelectColumn(ActivityTableMap::COL_NAME);
            $criteria->addSelectColumn(ActivityTableMap::COL_IFRAME);
            $criteria->addSelectColumn(ActivityTableMap::COL_READONLY);
            $criteria->addSelectColumn(ActivityTableMap::COL_WRITABLE);
            $criteria->addSelectColumn(ActivityTableMap::COL_POSTPONABLE);
            $criteria->addSelectColumn(ActivityTableMap::COL_COLOR);
            $criteria->addSelectColumn(ActivityTableMap::COL_TOOLBAR);
            $criteria->addSelectColumn(ActivityTableMap::COL_PRIORITY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.iframe');
            $criteria->addSelectColumn($alias . '.readonly');
            $criteria->addSelectColumn($alias . '.writable');
            $criteria->addSelectColumn($alias . '.postponable');
            $criteria->addSelectColumn($alias . '.color');
            $criteria->addSelectColumn($alias . '.toolbar');
            $criteria->addSelectColumn($alias . '.priority');
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
        return Propel::getServiceContainer()->getDatabaseMap(ActivityTableMap::DATABASE_NAME)->getTable(ActivityTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ActivityTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ActivityTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ActivityTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Activity or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Activity object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ActivityTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Perfumerlabs\Start\Model\Activity) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ActivityTableMap::DATABASE_NAME);
            $criteria->add(ActivityTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ActivityQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ActivityTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ActivityTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the activity table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ActivityQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Activity or Criteria object.
     *
     * @param mixed               $criteria Criteria or Activity object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ActivityTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Activity object
        }

        if ($criteria->containsKey(ActivityTableMap::COL_ID) && $criteria->keyContainsValue(ActivityTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ActivityTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ActivityQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ActivityTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ActivityTableMap::buildTableMap();
