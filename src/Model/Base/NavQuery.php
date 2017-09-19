<?php

namespace Perfumerlabs\Start\Model\Base;

use \Exception;
use \PDO;
use Perfumerlabs\Start\Model\Nav as ChildNav;
use Perfumerlabs\Start\Model\NavQuery as ChildNavQuery;
use Perfumerlabs\Start\Model\Map\NavTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'nav' table.
 *
 *
 *
 * @method     ChildNavQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildNavQuery orderByActivityId($order = Criteria::ASC) Order by the activity_id column
 * @method     ChildNavQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildNavQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildNavQuery orderByPriority($order = Criteria::ASC) Order by the priority column
 *
 * @method     ChildNavQuery groupById() Group by the id column
 * @method     ChildNavQuery groupByActivityId() Group by the activity_id column
 * @method     ChildNavQuery groupByName() Group by the name column
 * @method     ChildNavQuery groupByLink() Group by the link column
 * @method     ChildNavQuery groupByPriority() Group by the priority column
 *
 * @method     ChildNavQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNavQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNavQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNavQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildNavQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildNavQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildNavQuery leftJoinActivity($relationAlias = null) Adds a LEFT JOIN clause to the query using the Activity relation
 * @method     ChildNavQuery rightJoinActivity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Activity relation
 * @method     ChildNavQuery innerJoinActivity($relationAlias = null) Adds a INNER JOIN clause to the query using the Activity relation
 *
 * @method     ChildNavQuery joinWithActivity($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Activity relation
 *
 * @method     ChildNavQuery leftJoinWithActivity() Adds a LEFT JOIN clause and with to the query using the Activity relation
 * @method     ChildNavQuery rightJoinWithActivity() Adds a RIGHT JOIN clause and with to the query using the Activity relation
 * @method     ChildNavQuery innerJoinWithActivity() Adds a INNER JOIN clause and with to the query using the Activity relation
 *
 * @method     ChildNavQuery leftJoinNavAccess($relationAlias = null) Adds a LEFT JOIN clause to the query using the NavAccess relation
 * @method     ChildNavQuery rightJoinNavAccess($relationAlias = null) Adds a RIGHT JOIN clause to the query using the NavAccess relation
 * @method     ChildNavQuery innerJoinNavAccess($relationAlias = null) Adds a INNER JOIN clause to the query using the NavAccess relation
 *
 * @method     ChildNavQuery joinWithNavAccess($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the NavAccess relation
 *
 * @method     ChildNavQuery leftJoinWithNavAccess() Adds a LEFT JOIN clause and with to the query using the NavAccess relation
 * @method     ChildNavQuery rightJoinWithNavAccess() Adds a RIGHT JOIN clause and with to the query using the NavAccess relation
 * @method     ChildNavQuery innerJoinWithNavAccess() Adds a INNER JOIN clause and with to the query using the NavAccess relation
 *
 * @method     \Perfumerlabs\Start\Model\ActivityQuery|\Perfumerlabs\Start\Model\NavAccessQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNav findOne(ConnectionInterface $con = null) Return the first ChildNav matching the query
 * @method     ChildNav findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNav matching the query, or a new ChildNav object populated from the query conditions when no match is found
 *
 * @method     ChildNav findOneById(int $id) Return the first ChildNav filtered by the id column
 * @method     ChildNav findOneByActivityId(int $activity_id) Return the first ChildNav filtered by the activity_id column
 * @method     ChildNav findOneByName(string $name) Return the first ChildNav filtered by the name column
 * @method     ChildNav findOneByLink(string $link) Return the first ChildNav filtered by the link column
 * @method     ChildNav findOneByPriority(int $priority) Return the first ChildNav filtered by the priority column *

 * @method     ChildNav requirePk($key, ConnectionInterface $con = null) Return the ChildNav by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNav requireOne(ConnectionInterface $con = null) Return the first ChildNav matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNav requireOneById(int $id) Return the first ChildNav filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNav requireOneByActivityId(int $activity_id) Return the first ChildNav filtered by the activity_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNav requireOneByName(string $name) Return the first ChildNav filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNav requireOneByLink(string $link) Return the first ChildNav filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNav requireOneByPriority(int $priority) Return the first ChildNav filtered by the priority column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNav[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNav objects based on current ModelCriteria
 * @method     ChildNav[]|ObjectCollection findById(int $id) Return ChildNav objects filtered by the id column
 * @method     ChildNav[]|ObjectCollection findByActivityId(int $activity_id) Return ChildNav objects filtered by the activity_id column
 * @method     ChildNav[]|ObjectCollection findByName(string $name) Return ChildNav objects filtered by the name column
 * @method     ChildNav[]|ObjectCollection findByLink(string $link) Return ChildNav objects filtered by the link column
 * @method     ChildNav[]|ObjectCollection findByPriority(int $priority) Return ChildNav objects filtered by the priority column
 * @method     ChildNav[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NavQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Perfumerlabs\Start\Model\Base\NavQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'start', $modelName = '\\Perfumerlabs\\Start\\Model\\Nav', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNavQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNavQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNavQuery) {
            return $criteria;
        }
        $query = new ChildNavQuery();
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
     * @return ChildNav|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NavTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = NavTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildNav A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, activity_id, name, link, priority FROM nav WHERE id = :p0';
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
            /** @var ChildNav $obj */
            $obj = new ChildNav();
            $obj->hydrate($row);
            NavTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildNav|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NavTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NavTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(NavTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(NavTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the activity_id column
     *
     * Example usage:
     * <code>
     * $query->filterByActivityId(1234); // WHERE activity_id = 1234
     * $query->filterByActivityId(array(12, 34)); // WHERE activity_id IN (12, 34)
     * $query->filterByActivityId(array('min' => 12)); // WHERE activity_id > 12
     * </code>
     *
     * @see       filterByActivity()
     *
     * @param     mixed $activityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function filterByActivityId($activityId = null, $comparison = null)
    {
        if (is_array($activityId)) {
            $useMinMax = false;
            if (isset($activityId['min'])) {
                $this->addUsingAlias(NavTableMap::COL_ACTIVITY_ID, $activityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($activityId['max'])) {
                $this->addUsingAlias(NavTableMap::COL_ACTIVITY_ID, $activityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavTableMap::COL_ACTIVITY_ID, $activityId, $comparison);
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
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the link column
     *
     * Example usage:
     * <code>
     * $query->filterByLink('fooValue');   // WHERE link = 'fooValue'
     * $query->filterByLink('%fooValue%', Criteria::LIKE); // WHERE link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $link The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavTableMap::COL_LINK, $link, $comparison);
    }

    /**
     * Filter the query on the priority column
     *
     * Example usage:
     * <code>
     * $query->filterByPriority(1234); // WHERE priority = 1234
     * $query->filterByPriority(array(12, 34)); // WHERE priority IN (12, 34)
     * $query->filterByPriority(array('min' => 12)); // WHERE priority > 12
     * </code>
     *
     * @param     mixed $priority The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function filterByPriority($priority = null, $comparison = null)
    {
        if (is_array($priority)) {
            $useMinMax = false;
            if (isset($priority['min'])) {
                $this->addUsingAlias(NavTableMap::COL_PRIORITY, $priority['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priority['max'])) {
                $this->addUsingAlias(NavTableMap::COL_PRIORITY, $priority['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavTableMap::COL_PRIORITY, $priority, $comparison);
    }

    /**
     * Filter the query by a related \Perfumerlabs\Start\Model\Activity object
     *
     * @param \Perfumerlabs\Start\Model\Activity|ObjectCollection $activity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNavQuery The current query, for fluid interface
     */
    public function filterByActivity($activity, $comparison = null)
    {
        if ($activity instanceof \Perfumerlabs\Start\Model\Activity) {
            return $this
                ->addUsingAlias(NavTableMap::COL_ACTIVITY_ID, $activity->getId(), $comparison);
        } elseif ($activity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NavTableMap::COL_ACTIVITY_ID, $activity->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildNavQuery The current query, for fluid interface
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
     * Filter the query by a related \Perfumerlabs\Start\Model\NavAccess object
     *
     * @param \Perfumerlabs\Start\Model\NavAccess|ObjectCollection $navAccess the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildNavQuery The current query, for fluid interface
     */
    public function filterByNavAccess($navAccess, $comparison = null)
    {
        if ($navAccess instanceof \Perfumerlabs\Start\Model\NavAccess) {
            return $this
                ->addUsingAlias(NavTableMap::COL_ID, $navAccess->getNavId(), $comparison);
        } elseif ($navAccess instanceof ObjectCollection) {
            return $this
                ->useNavAccessQuery()
                ->filterByPrimaryKeys($navAccess->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNavAccess() only accepts arguments of type \Perfumerlabs\Start\Model\NavAccess or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the NavAccess relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function joinNavAccess($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('NavAccess');

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
            $this->addJoinObject($join, 'NavAccess');
        }

        return $this;
    }

    /**
     * Use the NavAccess relation NavAccess object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Perfumerlabs\Start\Model\NavAccessQuery A secondary query class using the current class as primary query
     */
    public function useNavAccessQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNavAccess($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'NavAccess', '\Perfumerlabs\Start\Model\NavAccessQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNav $nav Object to remove from the list of results
     *
     * @return $this|ChildNavQuery The current query, for fluid interface
     */
    public function prune($nav = null)
    {
        if ($nav) {
            $this->addUsingAlias(NavTableMap::COL_ID, $nav->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the nav table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NavTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NavTableMap::clearInstancePool();
            NavTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NavTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NavTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NavTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NavTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NavQuery
