<?php

namespace Perfumerlabs\Start\Model\Base;

use \Exception;
use \PDO;
use Perfumerlabs\Start\Model\Vendor as ChildVendor;
use Perfumerlabs\Start\Model\VendorQuery as ChildVendorQuery;
use Perfumerlabs\Start\Model\Map\VendorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'vendor' table.
 *
 *
 *
 * @method     ChildVendorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVendorQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildVendorQuery orderByHostname($order = Criteria::ASC) Order by the hostname column
 *
 * @method     ChildVendorQuery groupById() Group by the id column
 * @method     ChildVendorQuery groupByName() Group by the name column
 * @method     ChildVendorQuery groupByHostname() Group by the hostname column
 *
 * @method     ChildVendorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVendorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVendorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVendorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVendorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVendorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVendorQuery leftJoinActivity($relationAlias = null) Adds a LEFT JOIN clause to the query using the Activity relation
 * @method     ChildVendorQuery rightJoinActivity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Activity relation
 * @method     ChildVendorQuery innerJoinActivity($relationAlias = null) Adds a INNER JOIN clause to the query using the Activity relation
 *
 * @method     ChildVendorQuery joinWithActivity($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Activity relation
 *
 * @method     ChildVendorQuery leftJoinWithActivity() Adds a LEFT JOIN clause and with to the query using the Activity relation
 * @method     ChildVendorQuery rightJoinWithActivity() Adds a RIGHT JOIN clause and with to the query using the Activity relation
 * @method     ChildVendorQuery innerJoinWithActivity() Adds a INNER JOIN clause and with to the query using the Activity relation
 *
 * @method     \Perfumerlabs\Start\Model\ActivityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVendor findOne(ConnectionInterface $con = null) Return the first ChildVendor matching the query
 * @method     ChildVendor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVendor matching the query, or a new ChildVendor object populated from the query conditions when no match is found
 *
 * @method     ChildVendor findOneById(int $id) Return the first ChildVendor filtered by the id column
 * @method     ChildVendor findOneByName(string $name) Return the first ChildVendor filtered by the name column
 * @method     ChildVendor findOneByHostname(string $hostname) Return the first ChildVendor filtered by the hostname column *

 * @method     ChildVendor requirePk($key, ConnectionInterface $con = null) Return the ChildVendor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVendor requireOne(ConnectionInterface $con = null) Return the first ChildVendor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVendor requireOneById(int $id) Return the first ChildVendor filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVendor requireOneByName(string $name) Return the first ChildVendor filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVendor requireOneByHostname(string $hostname) Return the first ChildVendor filtered by the hostname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVendor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVendor objects based on current ModelCriteria
 * @method     ChildVendor[]|ObjectCollection findById(int $id) Return ChildVendor objects filtered by the id column
 * @method     ChildVendor[]|ObjectCollection findByName(string $name) Return ChildVendor objects filtered by the name column
 * @method     ChildVendor[]|ObjectCollection findByHostname(string $hostname) Return ChildVendor objects filtered by the hostname column
 * @method     ChildVendor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VendorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Perfumerlabs\Start\Model\Base\VendorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'start', $modelName = '\\Perfumerlabs\\Start\\Model\\Vendor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVendorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVendorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVendorQuery) {
            return $criteria;
        }
        $query = new ChildVendorQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildVendor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VendorTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VendorTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVendor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, hostname FROM vendor WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildVendor $obj */
            $obj = new ChildVendor();
            $obj->hydrate($row);
            VendorTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildVendor|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildVendorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VendorTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVendorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VendorTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVendorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VendorTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VendorTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VendorTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVendorQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VendorTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the hostname column
     *
     * Example usage:
     * <code>
     * $query->filterByHostname('fooValue');   // WHERE hostname = 'fooValue'
     * $query->filterByHostname('%fooValue%', Criteria::LIKE); // WHERE hostname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hostname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVendorQuery The current query, for fluid interface
     */
    public function filterByHostname($hostname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hostname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VendorTableMap::COL_HOSTNAME, $hostname, $comparison);
    }

    /**
     * Filter the query by a related \Perfumerlabs\Start\Model\Activity object
     *
     * @param \Perfumerlabs\Start\Model\Activity|ObjectCollection $activity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVendorQuery The current query, for fluid interface
     */
    public function filterByActivity($activity, $comparison = null)
    {
        if ($activity instanceof \Perfumerlabs\Start\Model\Activity) {
            return $this
                ->addUsingAlias(VendorTableMap::COL_ID, $activity->getVendorId(), $comparison);
        } elseif ($activity instanceof ObjectCollection) {
            return $this
                ->useActivityQuery()
                ->filterByPrimaryKeys($activity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByActivity() only accepts arguments of type \Perfumerlabs\Start\Model\Activity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Activity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVendorQuery The current query, for fluid interface
     */
    public function joinActivity($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Activity');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Activity');
        }

        return $this;
    }

    /**
     * Use the Activity relation Activity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Perfumerlabs\Start\Model\ActivityQuery A secondary query class using the current class as primary query
     */
    public function useActivityQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinActivity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Activity', '\Perfumerlabs\Start\Model\ActivityQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVendor $vendor Object to remove from the list of results
     *
     * @return $this|ChildVendorQuery The current query, for fluid interface
     */
    public function prune($vendor = null)
    {
        if ($vendor) {
            $this->addUsingAlias(VendorTableMap::COL_ID, $vendor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the vendor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VendorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VendorTableMap::clearInstancePool();
            VendorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VendorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VendorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VendorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VendorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VendorQuery
