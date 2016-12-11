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
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'activity' table.
 *
 *
 *
 * @method     ChildActivityQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildActivityQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildActivityQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildActivityQuery orderByPriority($order = Criteria::ASC) Order by the priority column
 * @method     ChildActivityQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildActivityQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     ChildActivityQuery orderByRaisedAt($order = Criteria::ASC) Order by the raised_at column
 * @method     ChildActivityQuery orderByPickedAt($order = Criteria::ASC) Order by the picked_at column
 * @method     ChildActivityQuery orderByClosedAt($order = Criteria::ASC) Order by the closed_at column
 * @method     ChildActivityQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildActivityQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildActivityQuery groupById() Group by the id column
 * @method     ChildActivityQuery groupByUserId() Group by the user_id column
 * @method     ChildActivityQuery groupByName() Group by the name column
 * @method     ChildActivityQuery groupByPriority() Group by the priority column
 * @method     ChildActivityQuery groupByTitle() Group by the title column
 * @method     ChildActivityQuery groupByData() Group by the data column
 * @method     ChildActivityQuery groupByRaisedAt() Group by the raised_at column
 * @method     ChildActivityQuery groupByPickedAt() Group by the picked_at column
 * @method     ChildActivityQuery groupByClosedAt() Group by the closed_at column
 * @method     ChildActivityQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildActivityQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildActivityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildActivityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildActivityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildActivity findOne(ConnectionInterface $con = null) Return the first ChildActivity matching the query
 * @method     ChildActivity findOneOrCreate(ConnectionInterface $con = null) Return the first ChildActivity matching the query, or a new ChildActivity object populated from the query conditions when no match is found
 *
 * @method     ChildActivity findOneById(int $id) Return the first ChildActivity filtered by the id column
 * @method     ChildActivity findOneByUserId(int $user_id) Return the first ChildActivity filtered by the user_id column
 * @method     ChildActivity findOneByName(string $name) Return the first ChildActivity filtered by the name column
 * @method     ChildActivity findOneByPriority(int $priority) Return the first ChildActivity filtered by the priority column
 * @method     ChildActivity findOneByTitle(string $title) Return the first ChildActivity filtered by the title column
 * @method     ChildActivity findOneByData(string $data) Return the first ChildActivity filtered by the data column
 * @method     ChildActivity findOneByRaisedAt(string $raised_at) Return the first ChildActivity filtered by the raised_at column
 * @method     ChildActivity findOneByPickedAt(string $picked_at) Return the first ChildActivity filtered by the picked_at column
 * @method     ChildActivity findOneByClosedAt(string $closed_at) Return the first ChildActivity filtered by the closed_at column
 * @method     ChildActivity findOneByCreatedAt(string $created_at) Return the first ChildActivity filtered by the created_at column
 * @method     ChildActivity findOneByUpdatedAt(string $updated_at) Return the first ChildActivity filtered by the updated_at column *

 * @method     ChildActivity requirePk($key, ConnectionInterface $con = null) Return the ChildActivity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOne(ConnectionInterface $con = null) Return the first ChildActivity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildActivity requireOneById(int $id) Return the first ChildActivity filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByUserId(int $user_id) Return the first ChildActivity filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByName(string $name) Return the first ChildActivity filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByPriority(int $priority) Return the first ChildActivity filtered by the priority column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByTitle(string $title) Return the first ChildActivity filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByData(string $data) Return the first ChildActivity filtered by the data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByRaisedAt(string $raised_at) Return the first ChildActivity filtered by the raised_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByPickedAt(string $picked_at) Return the first ChildActivity filtered by the picked_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByClosedAt(string $closed_at) Return the first ChildActivity filtered by the closed_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByCreatedAt(string $created_at) Return the first ChildActivity filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildActivity requireOneByUpdatedAt(string $updated_at) Return the first ChildActivity filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildActivity[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildActivity objects based on current ModelCriteria
 * @method     ChildActivity[]|ObjectCollection findById(int $id) Return ChildActivity objects filtered by the id column
 * @method     ChildActivity[]|ObjectCollection findByUserId(int $user_id) Return ChildActivity objects filtered by the user_id column
 * @method     ChildActivity[]|ObjectCollection findByName(string $name) Return ChildActivity objects filtered by the name column
 * @method     ChildActivity[]|ObjectCollection findByPriority(int $priority) Return ChildActivity objects filtered by the priority column
 * @method     ChildActivity[]|ObjectCollection findByTitle(string $title) Return ChildActivity objects filtered by the title column
 * @method     ChildActivity[]|ObjectCollection findByData(string $data) Return ChildActivity objects filtered by the data column
 * @method     ChildActivity[]|ObjectCollection findByRaisedAt(string $raised_at) Return ChildActivity objects filtered by the raised_at column
 * @method     ChildActivity[]|ObjectCollection findByPickedAt(string $picked_at) Return ChildActivity objects filtered by the picked_at column
 * @method     ChildActivity[]|ObjectCollection findByClosedAt(string $closed_at) Return ChildActivity objects filtered by the closed_at column
 * @method     ChildActivity[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildActivity objects filtered by the created_at column
 * @method     ChildActivity[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildActivity objects filtered by the updated_at column
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
        $sql = 'SELECT id, user_id, name, priority, title, data, raised_at, picked_at, closed_at, created_at, updated_at FROM activity WHERE id = :p0';
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
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(ActivityTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(ActivityTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_USER_ID, $userId, $comparison);
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
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByPriority($priority = null, $comparison = null)
    {
        if (is_array($priority)) {
            $useMinMax = false;
            if (isset($priority['min'])) {
                $this->addUsingAlias(ActivityTableMap::COL_PRIORITY, $priority['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priority['max'])) {
                $this->addUsingAlias(ActivityTableMap::COL_PRIORITY, $priority['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_PRIORITY, $priority, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the data column
     *
     * Example usage:
     * <code>
     * $query->filterByData('fooValue');   // WHERE data = 'fooValue'
     * $query->filterByData('%fooValue%'); // WHERE data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $data The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByData($data = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($data)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $data)) {
                $data = str_replace('*', '%', $data);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_DATA, $data, $comparison);
    }

    /**
     * Filter the query on the raised_at column
     *
     * Example usage:
     * <code>
     * $query->filterByRaisedAt('2011-03-14'); // WHERE raised_at = '2011-03-14'
     * $query->filterByRaisedAt('now'); // WHERE raised_at = '2011-03-14'
     * $query->filterByRaisedAt(array('max' => 'yesterday')); // WHERE raised_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $raisedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByRaisedAt($raisedAt = null, $comparison = null)
    {
        if (is_array($raisedAt)) {
            $useMinMax = false;
            if (isset($raisedAt['min'])) {
                $this->addUsingAlias(ActivityTableMap::COL_RAISED_AT, $raisedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($raisedAt['max'])) {
                $this->addUsingAlias(ActivityTableMap::COL_RAISED_AT, $raisedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_RAISED_AT, $raisedAt, $comparison);
    }

    /**
     * Filter the query on the picked_at column
     *
     * Example usage:
     * <code>
     * $query->filterByPickedAt('2011-03-14'); // WHERE picked_at = '2011-03-14'
     * $query->filterByPickedAt('now'); // WHERE picked_at = '2011-03-14'
     * $query->filterByPickedAt(array('max' => 'yesterday')); // WHERE picked_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $pickedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByPickedAt($pickedAt = null, $comparison = null)
    {
        if (is_array($pickedAt)) {
            $useMinMax = false;
            if (isset($pickedAt['min'])) {
                $this->addUsingAlias(ActivityTableMap::COL_PICKED_AT, $pickedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pickedAt['max'])) {
                $this->addUsingAlias(ActivityTableMap::COL_PICKED_AT, $pickedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_PICKED_AT, $pickedAt, $comparison);
    }

    /**
     * Filter the query on the closed_at column
     *
     * Example usage:
     * <code>
     * $query->filterByClosedAt('2011-03-14'); // WHERE closed_at = '2011-03-14'
     * $query->filterByClosedAt('now'); // WHERE closed_at = '2011-03-14'
     * $query->filterByClosedAt(array('max' => 'yesterday')); // WHERE closed_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $closedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByClosedAt($closedAt = null, $comparison = null)
    {
        if (is_array($closedAt)) {
            $useMinMax = false;
            if (isset($closedAt['min'])) {
                $this->addUsingAlias(ActivityTableMap::COL_CLOSED_AT, $closedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($closedAt['max'])) {
                $this->addUsingAlias(ActivityTableMap::COL_CLOSED_AT, $closedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_CLOSED_AT, $closedAt, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ActivityTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ActivityTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildActivityQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ActivityTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ActivityTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ActivityTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildActivityQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ActivityTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildActivityQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ActivityTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildActivityQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ActivityTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildActivityQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ActivityTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildActivityQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ActivityTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildActivityQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ActivityTableMap::COL_CREATED_AT);
    }

} // ActivityQuery
