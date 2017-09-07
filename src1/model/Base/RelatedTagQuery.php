<?php

namespace Perfumerlabs\Start\Model\Base;

use \Exception;
use \PDO;
use Perfumerlabs\Start\Model\RelatedTag as ChildRelatedTag;
use Perfumerlabs\Start\Model\RelatedTagQuery as ChildRelatedTagQuery;
use Perfumerlabs\Start\Model\Map\RelatedTagTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'related_tag' table.
 *
 *
 *
 * @method     ChildRelatedTagQuery orderByDutyId($order = Criteria::ASC) Order by the duty_id column
 * @method     ChildRelatedTagQuery orderByTagId($order = Criteria::ASC) Order by the tag_id column
 *
 * @method     ChildRelatedTagQuery groupByDutyId() Group by the duty_id column
 * @method     ChildRelatedTagQuery groupByTagId() Group by the tag_id column
 *
 * @method     ChildRelatedTagQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRelatedTagQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRelatedTagQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRelatedTagQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRelatedTagQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRelatedTagQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRelatedTagQuery leftJoinDuty($relationAlias = null) Adds a LEFT JOIN clause to the query using the Duty relation
 * @method     ChildRelatedTagQuery rightJoinDuty($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Duty relation
 * @method     ChildRelatedTagQuery innerJoinDuty($relationAlias = null) Adds a INNER JOIN clause to the query using the Duty relation
 *
 * @method     ChildRelatedTagQuery joinWithDuty($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Duty relation
 *
 * @method     ChildRelatedTagQuery leftJoinWithDuty() Adds a LEFT JOIN clause and with to the query using the Duty relation
 * @method     ChildRelatedTagQuery rightJoinWithDuty() Adds a RIGHT JOIN clause and with to the query using the Duty relation
 * @method     ChildRelatedTagQuery innerJoinWithDuty() Adds a INNER JOIN clause and with to the query using the Duty relation
 *
 * @method     ChildRelatedTagQuery leftJoinTag($relationAlias = null) Adds a LEFT JOIN clause to the query using the Tag relation
 * @method     ChildRelatedTagQuery rightJoinTag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Tag relation
 * @method     ChildRelatedTagQuery innerJoinTag($relationAlias = null) Adds a INNER JOIN clause to the query using the Tag relation
 *
 * @method     ChildRelatedTagQuery joinWithTag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Tag relation
 *
 * @method     ChildRelatedTagQuery leftJoinWithTag() Adds a LEFT JOIN clause and with to the query using the Tag relation
 * @method     ChildRelatedTagQuery rightJoinWithTag() Adds a RIGHT JOIN clause and with to the query using the Tag relation
 * @method     ChildRelatedTagQuery innerJoinWithTag() Adds a INNER JOIN clause and with to the query using the Tag relation
 *
 * @method     \Perfumerlabs\Start\Model\DutyQuery|\Perfumerlabs\Start\Model\TagQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRelatedTag findOne(ConnectionInterface $con = null) Return the first ChildRelatedTag matching the query
 * @method     ChildRelatedTag findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRelatedTag matching the query, or a new ChildRelatedTag object populated from the query conditions when no match is found
 *
 * @method     ChildRelatedTag findOneByDutyId(int $duty_id) Return the first ChildRelatedTag filtered by the duty_id column
 * @method     ChildRelatedTag findOneByTagId(int $tag_id) Return the first ChildRelatedTag filtered by the tag_id column *

 * @method     ChildRelatedTag requirePk($key, ConnectionInterface $con = null) Return the ChildRelatedTag by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRelatedTag requireOne(ConnectionInterface $con = null) Return the first ChildRelatedTag matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRelatedTag requireOneByDutyId(int $duty_id) Return the first ChildRelatedTag filtered by the duty_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRelatedTag requireOneByTagId(int $tag_id) Return the first ChildRelatedTag filtered by the tag_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRelatedTag[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRelatedTag objects based on current ModelCriteria
 * @method     ChildRelatedTag[]|ObjectCollection findByDutyId(int $duty_id) Return ChildRelatedTag objects filtered by the duty_id column
 * @method     ChildRelatedTag[]|ObjectCollection findByTagId(int $tag_id) Return ChildRelatedTag objects filtered by the tag_id column
 * @method     ChildRelatedTag[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RelatedTagQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Perfumerlabs\Start\Model\Base\RelatedTagQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'start', $modelName = '\\Perfumerlabs\\Start\\Model\\RelatedTag', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRelatedTagQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRelatedTagQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRelatedTagQuery) {
            return $criteria;
        }
        $query = new ChildRelatedTagQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$duty_id, $tag_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRelatedTag|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RelatedTagTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RelatedTagTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRelatedTag A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT duty_id, tag_id FROM related_tag WHERE duty_id = :p0 AND tag_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRelatedTag $obj */
            $obj = new ChildRelatedTag();
            $obj->hydrate($row);
            RelatedTagTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRelatedTag|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildRelatedTagQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RelatedTagTableMap::COL_DUTY_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RelatedTagTableMap::COL_TAG_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRelatedTagQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RelatedTagTableMap::COL_DUTY_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RelatedTagTableMap::COL_TAG_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the duty_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDutyId(1234); // WHERE duty_id = 1234
     * $query->filterByDutyId(array(12, 34)); // WHERE duty_id IN (12, 34)
     * $query->filterByDutyId(array('min' => 12)); // WHERE duty_id > 12
     * </code>
     *
     * @see       filterByDuty()
     *
     * @param     mixed $dutyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRelatedTagQuery The current query, for fluid interface
     */
    public function filterByDutyId($dutyId = null, $comparison = null)
    {
        if (is_array($dutyId)) {
            $useMinMax = false;
            if (isset($dutyId['min'])) {
                $this->addUsingAlias(RelatedTagTableMap::COL_DUTY_ID, $dutyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dutyId['max'])) {
                $this->addUsingAlias(RelatedTagTableMap::COL_DUTY_ID, $dutyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RelatedTagTableMap::COL_DUTY_ID, $dutyId, $comparison);
    }

    /**
     * Filter the query on the tag_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTagId(1234); // WHERE tag_id = 1234
     * $query->filterByTagId(array(12, 34)); // WHERE tag_id IN (12, 34)
     * $query->filterByTagId(array('min' => 12)); // WHERE tag_id > 12
     * </code>
     *
     * @see       filterByTag()
     *
     * @param     mixed $tagId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRelatedTagQuery The current query, for fluid interface
     */
    public function filterByTagId($tagId = null, $comparison = null)
    {
        if (is_array($tagId)) {
            $useMinMax = false;
            if (isset($tagId['min'])) {
                $this->addUsingAlias(RelatedTagTableMap::COL_TAG_ID, $tagId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tagId['max'])) {
                $this->addUsingAlias(RelatedTagTableMap::COL_TAG_ID, $tagId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RelatedTagTableMap::COL_TAG_ID, $tagId, $comparison);
    }

    /**
     * Filter the query by a related \Perfumerlabs\Start\Model\Duty object
     *
     * @param \Perfumerlabs\Start\Model\Duty|ObjectCollection $duty The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRelatedTagQuery The current query, for fluid interface
     */
    public function filterByDuty($duty, $comparison = null)
    {
        if ($duty instanceof \Perfumerlabs\Start\Model\Duty) {
            return $this
                ->addUsingAlias(RelatedTagTableMap::COL_DUTY_ID, $duty->getId(), $comparison);
        } elseif ($duty instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RelatedTagTableMap::COL_DUTY_ID, $duty->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRelatedTagQuery The current query, for fluid interface
     */
    public function joinDuty($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useDutyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDuty($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Duty', '\Perfumerlabs\Start\Model\DutyQuery');
    }

    /**
     * Filter the query by a related \Perfumerlabs\Start\Model\Tag object
     *
     * @param \Perfumerlabs\Start\Model\Tag|ObjectCollection $tag The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRelatedTagQuery The current query, for fluid interface
     */
    public function filterByTag($tag, $comparison = null)
    {
        if ($tag instanceof \Perfumerlabs\Start\Model\Tag) {
            return $this
                ->addUsingAlias(RelatedTagTableMap::COL_TAG_ID, $tag->getId(), $comparison);
        } elseif ($tag instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RelatedTagTableMap::COL_TAG_ID, $tag->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTag() only accepts arguments of type \Perfumerlabs\Start\Model\Tag or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Tag relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRelatedTagQuery The current query, for fluid interface
     */
    public function joinTag($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Tag');

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
            $this->addJoinObject($join, 'Tag');
        }

        return $this;
    }

    /**
     * Use the Tag relation Tag object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Perfumerlabs\Start\Model\TagQuery A secondary query class using the current class as primary query
     */
    public function useTagQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Tag', '\Perfumerlabs\Start\Model\TagQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRelatedTag $relatedTag Object to remove from the list of results
     *
     * @return $this|ChildRelatedTagQuery The current query, for fluid interface
     */
    public function prune($relatedTag = null)
    {
        if ($relatedTag) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RelatedTagTableMap::COL_DUTY_ID), $relatedTag->getDutyId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RelatedTagTableMap::COL_TAG_ID), $relatedTag->getTagId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the related_tag table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RelatedTagTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RelatedTagTableMap::clearInstancePool();
            RelatedTagTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RelatedTagTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RelatedTagTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RelatedTagTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RelatedTagTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RelatedTagQuery
