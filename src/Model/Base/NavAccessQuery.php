<?php

namespace Perfumerlabs\Start\Model\Base;

use \Exception;
use \PDO;
use App\Model\Role;
use App\Model\User;
use Perfumerlabs\Start\Model\NavAccess as ChildNavAccess;
use Perfumerlabs\Start\Model\NavAccessQuery as ChildNavAccessQuery;
use Perfumerlabs\Start\Model\Map\NavAccessTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'nav_access' table.
 *
 *
 *
 * @method     ChildNavAccessQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildNavAccessQuery orderByNavId($order = Criteria::ASC) Order by the nav_id column
 * @method     ChildNavAccessQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildNavAccessQuery orderByRoleId($order = Criteria::ASC) Order by the role_id column
 *
 * @method     ChildNavAccessQuery groupById() Group by the id column
 * @method     ChildNavAccessQuery groupByNavId() Group by the nav_id column
 * @method     ChildNavAccessQuery groupByUserId() Group by the user_id column
 * @method     ChildNavAccessQuery groupByRoleId() Group by the role_id column
 *
 * @method     ChildNavAccessQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNavAccessQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNavAccessQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNavAccessQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildNavAccessQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildNavAccessQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildNavAccessQuery leftJoinRole($relationAlias = null) Adds a LEFT JOIN clause to the query using the Role relation
 * @method     ChildNavAccessQuery rightJoinRole($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Role relation
 * @method     ChildNavAccessQuery innerJoinRole($relationAlias = null) Adds a INNER JOIN clause to the query using the Role relation
 *
 * @method     ChildNavAccessQuery joinWithRole($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Role relation
 *
 * @method     ChildNavAccessQuery leftJoinWithRole() Adds a LEFT JOIN clause and with to the query using the Role relation
 * @method     ChildNavAccessQuery rightJoinWithRole() Adds a RIGHT JOIN clause and with to the query using the Role relation
 * @method     ChildNavAccessQuery innerJoinWithRole() Adds a INNER JOIN clause and with to the query using the Role relation
 *
 * @method     ChildNavAccessQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildNavAccessQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildNavAccessQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildNavAccessQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildNavAccessQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildNavAccessQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildNavAccessQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildNavAccessQuery leftJoinNav($relationAlias = null) Adds a LEFT JOIN clause to the query using the Nav relation
 * @method     ChildNavAccessQuery rightJoinNav($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Nav relation
 * @method     ChildNavAccessQuery innerJoinNav($relationAlias = null) Adds a INNER JOIN clause to the query using the Nav relation
 *
 * @method     ChildNavAccessQuery joinWithNav($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Nav relation
 *
 * @method     ChildNavAccessQuery leftJoinWithNav() Adds a LEFT JOIN clause and with to the query using the Nav relation
 * @method     ChildNavAccessQuery rightJoinWithNav() Adds a RIGHT JOIN clause and with to the query using the Nav relation
 * @method     ChildNavAccessQuery innerJoinWithNav() Adds a INNER JOIN clause and with to the query using the Nav relation
 *
 * @method     \App\Model\RoleQuery|\App\Model\UserQuery|\Perfumerlabs\Start\Model\NavQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNavAccess findOne(ConnectionInterface $con = null) Return the first ChildNavAccess matching the query
 * @method     ChildNavAccess findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNavAccess matching the query, or a new ChildNavAccess object populated from the query conditions when no match is found
 *
 * @method     ChildNavAccess findOneById(int $id) Return the first ChildNavAccess filtered by the id column
 * @method     ChildNavAccess findOneByNavId(int $nav_id) Return the first ChildNavAccess filtered by the nav_id column
 * @method     ChildNavAccess findOneByUserId(int $user_id) Return the first ChildNavAccess filtered by the user_id column
 * @method     ChildNavAccess findOneByRoleId(int $role_id) Return the first ChildNavAccess filtered by the role_id column *

 * @method     ChildNavAccess requirePk($key, ConnectionInterface $con = null) Return the ChildNavAccess by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNavAccess requireOne(ConnectionInterface $con = null) Return the first ChildNavAccess matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNavAccess requireOneById(int $id) Return the first ChildNavAccess filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNavAccess requireOneByNavId(int $nav_id) Return the first ChildNavAccess filtered by the nav_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNavAccess requireOneByUserId(int $user_id) Return the first ChildNavAccess filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNavAccess requireOneByRoleId(int $role_id) Return the first ChildNavAccess filtered by the role_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNavAccess[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNavAccess objects based on current ModelCriteria
 * @method     ChildNavAccess[]|ObjectCollection findById(int $id) Return ChildNavAccess objects filtered by the id column
 * @method     ChildNavAccess[]|ObjectCollection findByNavId(int $nav_id) Return ChildNavAccess objects filtered by the nav_id column
 * @method     ChildNavAccess[]|ObjectCollection findByUserId(int $user_id) Return ChildNavAccess objects filtered by the user_id column
 * @method     ChildNavAccess[]|ObjectCollection findByRoleId(int $role_id) Return ChildNavAccess objects filtered by the role_id column
 * @method     ChildNavAccess[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NavAccessQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Perfumerlabs\Start\Model\Base\NavAccessQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'start', $modelName = '\\Perfumerlabs\\Start\\Model\\NavAccess', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNavAccessQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNavAccessQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNavAccessQuery) {
            return $criteria;
        }
        $query = new ChildNavAccessQuery();
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
     * @return ChildNavAccess|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NavAccessTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = NavAccessTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildNavAccess A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nav_id, user_id, role_id FROM nav_access WHERE id = :p0';
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
            /** @var ChildNavAccess $obj */
            $obj = new ChildNavAccess();
            $obj->hydrate($row);
            NavAccessTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildNavAccess|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NavAccessTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NavAccessTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(NavAccessTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(NavAccessTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavAccessTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the nav_id column
     *
     * Example usage:
     * <code>
     * $query->filterByNavId(1234); // WHERE nav_id = 1234
     * $query->filterByNavId(array(12, 34)); // WHERE nav_id IN (12, 34)
     * $query->filterByNavId(array('min' => 12)); // WHERE nav_id > 12
     * </code>
     *
     * @see       filterByNav()
     *
     * @param     mixed $navId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterByNavId($navId = null, $comparison = null)
    {
        if (is_array($navId)) {
            $useMinMax = false;
            if (isset($navId['min'])) {
                $this->addUsingAlias(NavAccessTableMap::COL_NAV_ID, $navId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($navId['max'])) {
                $this->addUsingAlias(NavAccessTableMap::COL_NAV_ID, $navId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavAccessTableMap::COL_NAV_ID, $navId, $comparison);
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
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(NavAccessTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(NavAccessTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavAccessTableMap::COL_USER_ID, $userId, $comparison);
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
     * @see       filterByRole()
     *
     * @param     mixed $roleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterByRoleId($roleId = null, $comparison = null)
    {
        if (is_array($roleId)) {
            $useMinMax = false;
            if (isset($roleId['min'])) {
                $this->addUsingAlias(NavAccessTableMap::COL_ROLE_ID, $roleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleId['max'])) {
                $this->addUsingAlias(NavAccessTableMap::COL_ROLE_ID, $roleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NavAccessTableMap::COL_ROLE_ID, $roleId, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\Role object
     *
     * @param \App\Model\Role|ObjectCollection $role The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterByRole($role, $comparison = null)
    {
        if ($role instanceof \App\Model\Role) {
            return $this
                ->addUsingAlias(NavAccessTableMap::COL_ROLE_ID, $role->getId(), $comparison);
        } elseif ($role instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NavAccessTableMap::COL_ROLE_ID, $role->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRole() only accepts arguments of type \App\Model\Role or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Role relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function joinRole($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Role');

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
            $this->addJoinObject($join, 'Role');
        }

        return $this;
    }

    /**
     * Use the Role relation Role object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\RoleQuery A secondary query class using the current class as primary query
     */
    public function useRoleQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRole($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Role', '\App\Model\RoleQuery');
    }

    /**
     * Filter the query by a related \App\Model\User object
     *
     * @param \App\Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \App\Model\User) {
            return $this
                ->addUsingAlias(NavAccessTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NavAccessTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \App\Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\App\Model\UserQuery');
    }

    /**
     * Filter the query by a related \Perfumerlabs\Start\Model\Nav object
     *
     * @param \Perfumerlabs\Start\Model\Nav|ObjectCollection $nav The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNavAccessQuery The current query, for fluid interface
     */
    public function filterByNav($nav, $comparison = null)
    {
        if ($nav instanceof \Perfumerlabs\Start\Model\Nav) {
            return $this
                ->addUsingAlias(NavAccessTableMap::COL_NAV_ID, $nav->getId(), $comparison);
        } elseif ($nav instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NavAccessTableMap::COL_NAV_ID, $nav->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByNav() only accepts arguments of type \Perfumerlabs\Start\Model\Nav or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Nav relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function joinNav($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Nav');

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
            $this->addJoinObject($join, 'Nav');
        }

        return $this;
    }

    /**
     * Use the Nav relation Nav object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Perfumerlabs\Start\Model\NavQuery A secondary query class using the current class as primary query
     */
    public function useNavQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNav($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Nav', '\Perfumerlabs\Start\Model\NavQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNavAccess $navAccess Object to remove from the list of results
     *
     * @return $this|ChildNavAccessQuery The current query, for fluid interface
     */
    public function prune($navAccess = null)
    {
        if ($navAccess) {
            $this->addUsingAlias(NavAccessTableMap::COL_ID, $navAccess->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the nav_access table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NavAccessTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NavAccessTableMap::clearInstancePool();
            NavAccessTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NavAccessTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NavAccessTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NavAccessTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NavAccessTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NavAccessQuery
