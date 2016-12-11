<?php

namespace Perfumerlabs\Start\Model\Base;

use \Exception;
use \PDO;
use Perfumerlabs\Start\Model\Schedule as ChildSchedule;
use Perfumerlabs\Start\Model\ScheduleQuery as ChildScheduleQuery;
use Perfumerlabs\Start\Model\Map\ScheduleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'schedule' table.
 *
 *
 *
 * @method     ChildScheduleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildScheduleQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildScheduleQuery orderByRoleId($order = Criteria::ASC) Order by the role_id column
 * @method     ChildScheduleQuery orderByActivities($order = Criteria::ASC) Order by the activities column
 * @method     ChildScheduleQuery orderByWeekDay($order = Criteria::ASC) Order by the week_day column
 * @method     ChildScheduleQuery orderByDate($order = Criteria::ASC) Order by the _date column
 * @method     ChildScheduleQuery orderByTimeFrom($order = Criteria::ASC) Order by the time_from column
 * @method     ChildScheduleQuery orderByTimeTo($order = Criteria::ASC) Order by the time_to column
 *
 * @method     ChildScheduleQuery groupById() Group by the id column
 * @method     ChildScheduleQuery groupByUserId() Group by the user_id column
 * @method     ChildScheduleQuery groupByRoleId() Group by the role_id column
 * @method     ChildScheduleQuery groupByActivities() Group by the activities column
 * @method     ChildScheduleQuery groupByWeekDay() Group by the week_day column
 * @method     ChildScheduleQuery groupByDate() Group by the _date column
 * @method     ChildScheduleQuery groupByTimeFrom() Group by the time_from column
 * @method     ChildScheduleQuery groupByTimeTo() Group by the time_to column
 *
 * @method     ChildScheduleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildScheduleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildScheduleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSchedule findOne(ConnectionInterface $con = null) Return the first ChildSchedule matching the query
 * @method     ChildSchedule findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSchedule matching the query, or a new ChildSchedule object populated from the query conditions when no match is found
 *
 * @method     ChildSchedule findOneById(int $id) Return the first ChildSchedule filtered by the id column
 * @method     ChildSchedule findOneByUserId(int $user_id) Return the first ChildSchedule filtered by the user_id column
 * @method     ChildSchedule findOneByRoleId(int $role_id) Return the first ChildSchedule filtered by the role_id column
 * @method     ChildSchedule findOneByActivities(array $activities) Return the first ChildSchedule filtered by the activities column
 * @method     ChildSchedule findOneByWeekDay(int $week_day) Return the first ChildSchedule filtered by the week_day column
 * @method     ChildSchedule findOneByDate(string $_date) Return the first ChildSchedule filtered by the _date column
 * @method     ChildSchedule findOneByTimeFrom(string $time_from) Return the first ChildSchedule filtered by the time_from column
 * @method     ChildSchedule findOneByTimeTo(string $time_to) Return the first ChildSchedule filtered by the time_to column *

 * @method     ChildSchedule requirePk($key, ConnectionInterface $con = null) Return the ChildSchedule by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOne(ConnectionInterface $con = null) Return the first ChildSchedule matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSchedule requireOneById(int $id) Return the first ChildSchedule filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByUserId(int $user_id) Return the first ChildSchedule filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByRoleId(int $role_id) Return the first ChildSchedule filtered by the role_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByActivities(array $activities) Return the first ChildSchedule filtered by the activities column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByWeekDay(int $week_day) Return the first ChildSchedule filtered by the week_day column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByDate(string $_date) Return the first ChildSchedule filtered by the _date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByTimeFrom(string $time_from) Return the first ChildSchedule filtered by the time_from column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByTimeTo(string $time_to) Return the first ChildSchedule filtered by the time_to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSchedule[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSchedule objects based on current ModelCriteria
 * @method     ChildSchedule[]|ObjectCollection findById(int $id) Return ChildSchedule objects filtered by the id column
 * @method     ChildSchedule[]|ObjectCollection findByUserId(int $user_id) Return ChildSchedule objects filtered by the user_id column
 * @method     ChildSchedule[]|ObjectCollection findByRoleId(int $role_id) Return ChildSchedule objects filtered by the role_id column
 * @method     ChildSchedule[]|ObjectCollection findByActivities(array $activities) Return ChildSchedule objects filtered by the activities column
 * @method     ChildSchedule[]|ObjectCollection findByWeekDay(int $week_day) Return ChildSchedule objects filtered by the week_day column
 * @method     ChildSchedule[]|ObjectCollection findByDate(string $_date) Return ChildSchedule objects filtered by the _date column
 * @method     ChildSchedule[]|ObjectCollection findByTimeFrom(string $time_from) Return ChildSchedule objects filtered by the time_from column
 * @method     ChildSchedule[]|ObjectCollection findByTimeTo(string $time_to) Return ChildSchedule objects filtered by the time_to column
 * @method     ChildSchedule[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ScheduleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Perfumerlabs\Start\Model\Base\ScheduleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'start', $modelName = '\\Perfumerlabs\\Start\\Model\\Schedule', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildScheduleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildScheduleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildScheduleQuery) {
            return $criteria;
        }
        $query = new ChildScheduleQuery();
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
     * @return ChildSchedule|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ScheduleTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ScheduleTableMap::DATABASE_NAME);
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
     * @return ChildSchedule A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_id, role_id, activities, week_day, _date, time_from, time_to FROM schedule WHERE id = :p0';
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
            /** @var ChildSchedule $obj */
            $obj = new ChildSchedule();
            $obj->hydrate($row);
            ScheduleTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSchedule|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ScheduleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ScheduleTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the role_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRoleId(1234); // WHERE role_id = 1234
     * $query->filterByRoleId(array(12, 34)); // WHERE role_id IN (12, 34)
     * $query->filterByRoleId(array('min' => 12)); // WHERE role_id > 12
     * </code>
     *
     * @param     mixed $roleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByRoleId($roleId = null, $comparison = null)
    {
        if (is_array($roleId)) {
            $useMinMax = false;
            if (isset($roleId['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_ROLE_ID, $roleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleId['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_ROLE_ID, $roleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_ROLE_ID, $roleId, $comparison);
    }

    /**
     * Filter the query on the activities column
     *
     * @param     array $activities The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByActivities($activities = null, $comparison = null)
    {
        $key = $this->getAliasedColName(ScheduleTableMap::COL_ACTIVITIES);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($activities as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($activities as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($activities as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_ACTIVITIES, $activities, $comparison);
    }

    /**
     * Filter the query on the activities column
     * @param     mixed $activities The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByActivitie($activities = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($activities)) {
                $activities = '%| ' . $activities . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $activities = '%| ' . $activities . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(ScheduleTableMap::COL_ACTIVITIES);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $activities, $comparison);
            } else {
                $this->addAnd($key, $activities, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_ACTIVITIES, $activities, $comparison);
    }

    /**
     * Filter the query on the week_day column
     *
     * Example usage:
     * <code>
     * $query->filterByWeekDay(1234); // WHERE week_day = 1234
     * $query->filterByWeekDay(array(12, 34)); // WHERE week_day IN (12, 34)
     * $query->filterByWeekDay(array('min' => 12)); // WHERE week_day > 12
     * </code>
     *
     * @param     mixed $weekDay The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByWeekDay($weekDay = null, $comparison = null)
    {
        if (is_array($weekDay)) {
            $useMinMax = false;
            if (isset($weekDay['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_WEEK_DAY, $weekDay['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weekDay['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_WEEK_DAY, $weekDay['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_WEEK_DAY, $weekDay, $comparison);
    }

    /**
     * Filter the query on the _date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE _date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE _date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE _date > '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL__DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL__DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL__DATE, $date, $comparison);
    }

    /**
     * Filter the query on the time_from column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeFrom('2011-03-14'); // WHERE time_from = '2011-03-14'
     * $query->filterByTimeFrom('now'); // WHERE time_from = '2011-03-14'
     * $query->filterByTimeFrom(array('max' => 'yesterday')); // WHERE time_from > '2011-03-13'
     * </code>
     *
     * @param     mixed $timeFrom The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByTimeFrom($timeFrom = null, $comparison = null)
    {
        if (is_array($timeFrom)) {
            $useMinMax = false;
            if (isset($timeFrom['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_TIME_FROM, $timeFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeFrom['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_TIME_FROM, $timeFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_TIME_FROM, $timeFrom, $comparison);
    }

    /**
     * Filter the query on the time_to column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeTo('2011-03-14'); // WHERE time_to = '2011-03-14'
     * $query->filterByTimeTo('now'); // WHERE time_to = '2011-03-14'
     * $query->filterByTimeTo(array('max' => 'yesterday')); // WHERE time_to > '2011-03-13'
     * </code>
     *
     * @param     mixed $timeTo The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByTimeTo($timeTo = null, $comparison = null)
    {
        if (is_array($timeTo)) {
            $useMinMax = false;
            if (isset($timeTo['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_TIME_TO, $timeTo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeTo['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_TIME_TO, $timeTo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_TIME_TO, $timeTo, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSchedule $schedule Object to remove from the list of results
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function prune($schedule = null)
    {
        if ($schedule) {
            $this->addUsingAlias(ScheduleTableMap::COL_ID, $schedule->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the schedule table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ScheduleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ScheduleTableMap::clearInstancePool();
            ScheduleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ScheduleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ScheduleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ScheduleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ScheduleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ScheduleQuery
