<?php

namespace Perfumerlabs\Start\Model\Base;

use \Exception;
use \PDO;
use Perfumerlabs\Start\Model\Activity as ChildActivity;
use Perfumerlabs\Start\Model\ActivityQuery as ChildActivityQuery;
use Perfumerlabs\Start\Model\Map\ActivityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'activity' table.
 *
 *
 *
 * @method     ChildActivityQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildActivityQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildActivityQuery orderByAmd($order = Criteria::ASC) Order by the amd column
 * @method     ChildActivityQuery orderByIframe($order = Criteria::ASC) Order by the iframe column
 * @method     ChildActivityQuery orderByReadonly($order = Criteria::ASC) Order by the readonly column
 *
 * @method     ChildActivityQuery groupById() Group by the id column
 * @method     ChildActivityQuery groupByName() Group by the name column
 * @method     ChildActivityQuery groupByAmd() Group by the amd column
 * @method     ChildActivityQuery groupByIframe() Group by the iframe column
 * @method     ChildActivityQuery groupByReadonly() Group by the readonly column
 *
 * @method     ChildActivityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildActivityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildActivityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildActivityQuery leftJoinDuty($relationAlias = null) Adds a LEFT JOIN clause to the query using the Duty relation
 * @method     ChildActivityQuery rightJoinDuty($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Duty relation
 * @method     ChildActivityQuery innerJoinDuty($relationAlias = null) Adds a INNER JOIN clause to the query using the Duty relation
 *
 * @method     \Perfumerlabs\Start\Model\DutyQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildActivity findOne(ConnectionInterface $con = null) Return the first ChildActivity matching the query
 * @method     ChildActivity findOneOrCreate(ConnectionInterface $con = null) Return the first ChildActivity matching the query, or a new ChildActivity object populated from the query conditions when no match is found
 *
 * @method     ChildActivity findOneById(int $id) Return the first ChildActivity filtered by the id column
 * @method     ChildActivity findOneByName(string $name) Return the first ChildActivity filtered by the name column
 * @method     ChildActivity findOneByAmd(string $amd) Return the first ChildActivity filtered by the amd column
 * @method     ChildActivity findOneByIframe(string $iframe) Return the first ChildActivity filtered by the iframe column
 * @method     ChildActivity findOneByReadonly(boolean $readonly) Return the first ChildActivity filtered by the readonly column *

 * @method     ChildActivity requirePk($key, ConnectionInterface $con = null) Return the ChildActivity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOne(ConnectionInterface $con = null) Return the first ChildActivity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildActivity requireOneById(int $id) Return the first ChildActivity filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByName(string $name) Return the first ChildActivity filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByAmd(string $amd) Return the first ChildActivity filtered by the amd column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByIframe(string $iframe) Return the first ChildActivity filtered by the iframe column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByReadonly(boolean $readonly) Return the first ChildActivity filtered by the readonly column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildActivity[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildActivity objects based on current ModelCriteria
 * @method     ChildActivity[]|ObjectCollection findById(int $id) Return ChildActivity objects filtered by the id column
 * @method     ChildActivity[]|ObjectCollection findByName(string $name) Return ChildActivity objects filtered by the name column
 * @method     ChildActivity[]|ObjectCollection findByAmd(string $amd) Return ChildActivity objects filtered by the amd column
 * @method     ChildActivity[]|ObjectCollection findByIframe(string $iframe) Return ChildActivity objects filtered by the iframe column
 * @method     ChildActivity[]|ObjectCollection findByReadonly(boolean $readonly) Return ChildActivity objects filtered by the readonly column
 * @method     ChildActivity[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ActivityQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Perfumerlabs\Start\Model\Base\ActivityQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'start', $modelName = '\\Perfumerlabs\\Start\\Model\\Activity', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildActivityQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildActivityQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildActivityQuery) {
            return $criteria;
        }
        $query = new ChildActivityQuery();
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
     * @return ChildActivity|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ActivityTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ActivityTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
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
     * @return ChildActivity A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, amd, iframe, readonly FROM activity WHERE id = :p0';
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
            /** @var ChildActivity $obj */
            $obj = new ChildActivity();
            $obj->hydrate($row);
            ActivityTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildActivity|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ActivityTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ActivityTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ActivityTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ActivityTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the amd column
     *
     * Example usage:
     * <code>
     * $query->filterByAmd('fooValue');   // WHERE amd = 'fooValue'
     * $query->filterByAmd('%fooValue%'); // WHERE amd LIKE '%fooValue%'
     * </code>
     *
     * @param     string $amd The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByAmd($amd = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($amd)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $amd)) {
                $amd = str_replace('*', '%', $amd);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_AMD, $amd, $comparison);
    }

    /**
     * Filter the query on the iframe column
     *
     * Example usage:
     * <code>
     * $query->filterByIframe('fooValue');   // WHERE iframe = 'fooValue'
     * $query->filterByIframe('%fooValue%'); // WHERE iframe LIKE '%fooValue%'
     * </code>
     *
     * @param     string $iframe The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByIframe($iframe = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($iframe)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $iframe)) {
                $iframe = str_replace('*', '%', $iframe);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_IFRAME, $iframe, $comparison);
    }

    /**
     * Filter the query on the readonly column
     *
     * Example usage:
     * <code>
     * $query->filterByReadonly(true); // WHERE readonly = true
     * $query->filterByReadonly('yes'); // WHERE readonly = true
     * </code>
     *
     * @param     boolean|string $readonly The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByReadonly($readonly = null, $comparison = null)
    {
        if (is_string($readonly)) {
            $readonly = in_array(strtolower($readonly), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ActivityTableMap::COL_READONLY, $readonly, $comparison);
    }

    /**
     * Filter the query by a related \Perfumerlabs\Start\Model\Duty object
     *
     * @param \Perfumerlabs\Start\Model\Duty|ObjectCollection $duty the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildActivityQuery The current query, for fluid interface
     */
    public function filterByDuty($duty, $comparison = null)
    {
        if ($duty instanceof \Perfumerlabs\Start\Model\Duty) {
            return $this
                ->addUsingAlias(ActivityTableMap::COL_ID, $duty->getActivityId(), $comparison);
        } elseif ($duty instanceof ObjectCollection) {
            return $this
                ->useDutyQuery()
                ->filterByPrimaryKeys($duty->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDuty() only accepts arguments of type \Perfumerlabs\Start\Model\Duty or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Duty relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function joinDuty($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Duty');

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
            $this->addJoinObject($join, 'Duty');
        }

        return $this;
    }

    /**
     * Use the Duty relation Duty object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Perfumerlabs\Start\Model\DutyQuery A secondary query class using the current class as primary query
     */
    public function useDutyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDuty($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Duty', '\Perfumerlabs\Start\Model\DutyQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildActivity $activity Object to remove from the list of results
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function prune($activity = null)
    {
        if ($activity) {
            $this->addUsingAlias(ActivityTableMap::COL_ID, $activity->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the activity table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ActivityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ActivityTableMap::clearInstancePool();
            ActivityTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ActivityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ActivityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ActivityTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ActivityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ActivityQuery
