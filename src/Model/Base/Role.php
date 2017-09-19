<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\Role as ChildRole;
use App\Model\RoleQuery as ChildRoleQuery;
use App\Model\User as ChildUser;
use App\Model\UserQuery as ChildUserQuery;
use App\Model\UserRole as ChildUserRole;
use App\Model\UserRoleQuery as ChildUserRoleQuery;
use App\Model\Map\RoleTableMap;
use App\Model\Map\UserRoleTableMap;
use Perfumerlabs\Start\Model\ActivityAccess;
use Perfumerlabs\Start\Model\ActivityAccessQuery;
use Perfumerlabs\Start\Model\NavAccess;
use Perfumerlabs\Start\Model\NavAccessQuery;
use Perfumerlabs\Start\Model\Base\ActivityAccess as BaseActivityAccess;
use Perfumerlabs\Start\Model\Base\NavAccess as BaseNavAccess;
use Perfumerlabs\Start\Model\Map\ActivityAccessTableMap;
use Perfumerlabs\Start\Model\Map\NavAccessTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the '_role' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Role implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Model\\Map\\RoleTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the permission field.
     *
     * @var        string
     */
    protected $permission;

    /**
     * @var        ObjectCollection|ChildUserRole[] Collection to store aggregation of ChildUserRole objects.
     */
    protected $collUserRoles;
    protected $collUserRolesPartial;

    /**
     * @var        ObjectCollection|NavAccess[] Collection to store aggregation of NavAccess objects.
     */
    protected $collNavAccesses;
    protected $collNavAccessesPartial;

    /**
     * @var        ObjectCollection|ActivityAccess[] Collection to store aggregation of ActivityAccess objects.
     */
    protected $collActivityAccesses;
    protected $collActivityAccessesPartial;

    /**
     * @var        ObjectCollection|ChildUser[] Cross Collection to store aggregation of ChildUser objects.
     */
    protected $collUsers;

    /**
     * @var bool
     */
    protected $collUsersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUser[]
     */
    protected $usersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserRole[]
     */
    protected $userRolesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|NavAccess[]
     */
    protected $navAccessesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ActivityAccess[]
     */
    protected $activityAccessesScheduledForDeletion = null;

    /**
     * Initializes internal state of App\Model\Base\Role object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Role</code> instance.  If
     * <code>obj</code> is an instance of <code>Role</code>, delegates to
     * <code>equals(Role)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Role The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [permission] column value.
     *
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\App\Model\Role The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[RoleTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\App\Model\Role The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[RoleTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [permission] column.
     *
     * @param string $v new value
     * @return $this|\App\Model\Role The current object (for fluent API support)
     */
    public function setPermission($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->permission !== $v) {
            $this->permission = $v;
            $this->modifiedColumns[RoleTableMap::COL_PERMISSION] = true;
        }

        return $this;
    } // setPermission()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RoleTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RoleTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RoleTableMap::translateFieldName('Permission', TableMap::TYPE_PHPNAME, $indexType)];
            $this->permission = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = RoleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Model\\Role'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RoleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRoleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collUserRoles = null;

            $this->collNavAccesses = null;

            $this->collActivityAccesses = null;

            $this->collUsers = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Role::setDeleted()
     * @see Role::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRoleQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoleTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                RoleTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->usersScheduledForDeletion !== null) {
                if (!$this->usersScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->usersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \App\Model\UserRoleQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->usersScheduledForDeletion = null;
                }

            }

            if ($this->collUsers) {
                foreach ($this->collUsers as $user) {
                    if (!$user->isDeleted() && ($user->isNew() || $user->isModified())) {
                        $user->save($con);
                    }
                }
            }


            if ($this->userRolesScheduledForDeletion !== null) {
                if (!$this->userRolesScheduledForDeletion->isEmpty()) {
                    \App\Model\UserRoleQuery::create()
                        ->filterByPrimaryKeys($this->userRolesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userRolesScheduledForDeletion = null;
                }
            }

            if ($this->collUserRoles !== null) {
                foreach ($this->collUserRoles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->navAccessesScheduledForDeletion !== null) {
                if (!$this->navAccessesScheduledForDeletion->isEmpty()) {
                    \Perfumerlabs\Start\Model\NavAccessQuery::create()
                        ->filterByPrimaryKeys($this->navAccessesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->navAccessesScheduledForDeletion = null;
                }
            }

            if ($this->collNavAccesses !== null) {
                foreach ($this->collNavAccesses as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->activityAccessesScheduledForDeletion !== null) {
                if (!$this->activityAccessesScheduledForDeletion->isEmpty()) {
                    \Perfumerlabs\Start\Model\ActivityAccessQuery::create()
                        ->filterByPrimaryKeys($this->activityAccessesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->activityAccessesScheduledForDeletion = null;
                }
            }

            if ($this->collActivityAccesses !== null) {
                foreach ($this->collActivityAccesses as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[RoleTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RoleTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('_role_id_seq')");
                $this->id = (int) $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RoleTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(RoleTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(RoleTableMap::COL_PERMISSION)) {
            $modifiedColumns[':p' . $index++]  = 'permission';
        }

        $sql = sprintf(
            'INSERT INTO _role (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'permission':
                        $stmt->bindValue($identifier, $this->permission, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RoleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getPermission();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Role'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Role'][$this->hashCode()] = true;
        $keys = RoleTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getPermission(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collUserRoles) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userRoles';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_user_roles';
                        break;
                    default:
                        $key = 'UserRoles';
                }

                $result[$key] = $this->collUserRoles->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collNavAccesses) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'navAccesses';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'nav_accesses';
                        break;
                    default:
                        $key = 'NavAccesses';
                }

                $result[$key] = $this->collNavAccesses->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collActivityAccesses) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'activityAccesses';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'activity_accesses';
                        break;
                    default:
                        $key = 'ActivityAccesses';
                }

                $result[$key] = $this->collActivityAccesses->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\Model\Role
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RoleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Model\Role
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setPermission($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = RoleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPermission($arr[$keys[2]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\App\Model\Role The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(RoleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RoleTableMap::COL_ID)) {
            $criteria->add(RoleTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(RoleTableMap::COL_NAME)) {
            $criteria->add(RoleTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(RoleTableMap::COL_PERMISSION)) {
            $criteria->add(RoleTableMap::COL_PERMISSION, $this->permission);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildRoleQuery::create();
        $criteria->add(RoleTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\Model\Role (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setPermission($this->getPermission());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getUserRoles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserRole($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getNavAccesses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addNavAccess($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getActivityAccesses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addActivityAccess($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Model\Role Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('UserRole' == $relationName) {
            return $this->initUserRoles();
        }
        if ('NavAccess' == $relationName) {
            return $this->initNavAccesses();
        }
        if ('ActivityAccess' == $relationName) {
            return $this->initActivityAccesses();
        }
    }

    /**
     * Clears out the collUserRoles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserRoles()
     */
    public function clearUserRoles()
    {
        $this->collUserRoles = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserRoles collection loaded partially.
     */
    public function resetPartialUserRoles($v = true)
    {
        $this->collUserRolesPartial = $v;
    }

    /**
     * Initializes the collUserRoles collection.
     *
     * By default this just sets the collUserRoles collection to an empty array (like clearcollUserRoles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserRoles($overrideExisting = true)
    {
        if (null !== $this->collUserRoles && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserRoleTableMap::getTableMap()->getCollectionClassName();

        $this->collUserRoles = new $collectionClassName;
        $this->collUserRoles->setModel('\App\Model\UserRole');
    }

    /**
     * Gets an array of ChildUserRole objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRole is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserRole[] List of ChildUserRole objects
     * @throws PropelException
     */
    public function getUserRoles(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserRolesPartial && !$this->isNew();
        if (null === $this->collUserRoles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserRoles) {
                // return empty collection
                $this->initUserRoles();
            } else {
                $collUserRoles = ChildUserRoleQuery::create(null, $criteria)
                    ->filterByRole($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserRolesPartial && count($collUserRoles)) {
                        $this->initUserRoles(false);

                        foreach ($collUserRoles as $obj) {
                            if (false == $this->collUserRoles->contains($obj)) {
                                $this->collUserRoles->append($obj);
                            }
                        }

                        $this->collUserRolesPartial = true;
                    }

                    return $collUserRoles;
                }

                if ($partial && $this->collUserRoles) {
                    foreach ($this->collUserRoles as $obj) {
                        if ($obj->isNew()) {
                            $collUserRoles[] = $obj;
                        }
                    }
                }

                $this->collUserRoles = $collUserRoles;
                $this->collUserRolesPartial = false;
            }
        }

        return $this->collUserRoles;
    }

    /**
     * Sets a collection of ChildUserRole objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userRoles A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRole The current object (for fluent API support)
     */
    public function setUserRoles(Collection $userRoles, ConnectionInterface $con = null)
    {
        /** @var ChildUserRole[] $userRolesToDelete */
        $userRolesToDelete = $this->getUserRoles(new Criteria(), $con)->diff($userRoles);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userRolesScheduledForDeletion = clone $userRolesToDelete;

        foreach ($userRolesToDelete as $userRoleRemoved) {
            $userRoleRemoved->setRole(null);
        }

        $this->collUserRoles = null;
        foreach ($userRoles as $userRole) {
            $this->addUserRole($userRole);
        }

        $this->collUserRoles = $userRoles;
        $this->collUserRolesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserRole objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserRole objects.
     * @throws PropelException
     */
    public function countUserRoles(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserRolesPartial && !$this->isNew();
        if (null === $this->collUserRoles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserRoles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserRoles());
            }

            $query = ChildUserRoleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRole($this)
                ->count($con);
        }

        return count($this->collUserRoles);
    }

    /**
     * Method called to associate a ChildUserRole object to this object
     * through the ChildUserRole foreign key attribute.
     *
     * @param  ChildUserRole $l ChildUserRole
     * @return $this|\App\Model\Role The current object (for fluent API support)
     */
    public function addUserRole(ChildUserRole $l)
    {
        if ($this->collUserRoles === null) {
            $this->initUserRoles();
            $this->collUserRolesPartial = true;
        }

        if (!$this->collUserRoles->contains($l)) {
            $this->doAddUserRole($l);

            if ($this->userRolesScheduledForDeletion and $this->userRolesScheduledForDeletion->contains($l)) {
                $this->userRolesScheduledForDeletion->remove($this->userRolesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserRole $userRole The ChildUserRole object to add.
     */
    protected function doAddUserRole(ChildUserRole $userRole)
    {
        $this->collUserRoles[]= $userRole;
        $userRole->setRole($this);
    }

    /**
     * @param  ChildUserRole $userRole The ChildUserRole object to remove.
     * @return $this|ChildRole The current object (for fluent API support)
     */
    public function removeUserRole(ChildUserRole $userRole)
    {
        if ($this->getUserRoles()->contains($userRole)) {
            $pos = $this->collUserRoles->search($userRole);
            $this->collUserRoles->remove($pos);
            if (null === $this->userRolesScheduledForDeletion) {
                $this->userRolesScheduledForDeletion = clone $this->collUserRoles;
                $this->userRolesScheduledForDeletion->clear();
            }
            $this->userRolesScheduledForDeletion[]= clone $userRole;
            $userRole->setRole(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Role is new, it will return
     * an empty collection; or if this Role has previously
     * been saved, it will retrieve related UserRoles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Role.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserRole[] List of ChildUserRole objects
     */
    public function getUserRolesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserRoleQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getUserRoles($query, $con);
    }

    /**
     * Clears out the collNavAccesses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addNavAccesses()
     */
    public function clearNavAccesses()
    {
        $this->collNavAccesses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collNavAccesses collection loaded partially.
     */
    public function resetPartialNavAccesses($v = true)
    {
        $this->collNavAccessesPartial = $v;
    }

    /**
     * Initializes the collNavAccesses collection.
     *
     * By default this just sets the collNavAccesses collection to an empty array (like clearcollNavAccesses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initNavAccesses($overrideExisting = true)
    {
        if (null !== $this->collNavAccesses && !$overrideExisting) {
            return;
        }

        $collectionClassName = NavAccessTableMap::getTableMap()->getCollectionClassName();

        $this->collNavAccesses = new $collectionClassName;
        $this->collNavAccesses->setModel('\Perfumerlabs\Start\Model\NavAccess');
    }

    /**
     * Gets an array of NavAccess objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRole is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|NavAccess[] List of NavAccess objects
     * @throws PropelException
     */
    public function getNavAccesses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collNavAccessesPartial && !$this->isNew();
        if (null === $this->collNavAccesses || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collNavAccesses) {
                // return empty collection
                $this->initNavAccesses();
            } else {
                $collNavAccesses = NavAccessQuery::create(null, $criteria)
                    ->filterByRole($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collNavAccessesPartial && count($collNavAccesses)) {
                        $this->initNavAccesses(false);

                        foreach ($collNavAccesses as $obj) {
                            if (false == $this->collNavAccesses->contains($obj)) {
                                $this->collNavAccesses->append($obj);
                            }
                        }

                        $this->collNavAccessesPartial = true;
                    }

                    return $collNavAccesses;
                }

                if ($partial && $this->collNavAccesses) {
                    foreach ($this->collNavAccesses as $obj) {
                        if ($obj->isNew()) {
                            $collNavAccesses[] = $obj;
                        }
                    }
                }

                $this->collNavAccesses = $collNavAccesses;
                $this->collNavAccessesPartial = false;
            }
        }

        return $this->collNavAccesses;
    }

    /**
     * Sets a collection of NavAccess objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $navAccesses A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRole The current object (for fluent API support)
     */
    public function setNavAccesses(Collection $navAccesses, ConnectionInterface $con = null)
    {
        /** @var NavAccess[] $navAccessesToDelete */
        $navAccessesToDelete = $this->getNavAccesses(new Criteria(), $con)->diff($navAccesses);


        $this->navAccessesScheduledForDeletion = $navAccessesToDelete;

        foreach ($navAccessesToDelete as $navAccessRemoved) {
            $navAccessRemoved->setRole(null);
        }

        $this->collNavAccesses = null;
        foreach ($navAccesses as $navAccess) {
            $this->addNavAccess($navAccess);
        }

        $this->collNavAccesses = $navAccesses;
        $this->collNavAccessesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseNavAccess objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseNavAccess objects.
     * @throws PropelException
     */
    public function countNavAccesses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collNavAccessesPartial && !$this->isNew();
        if (null === $this->collNavAccesses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collNavAccesses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getNavAccesses());
            }

            $query = NavAccessQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRole($this)
                ->count($con);
        }

        return count($this->collNavAccesses);
    }

    /**
     * Method called to associate a NavAccess object to this object
     * through the NavAccess foreign key attribute.
     *
     * @param  NavAccess $l NavAccess
     * @return $this|\App\Model\Role The current object (for fluent API support)
     */
    public function addNavAccess(NavAccess $l)
    {
        if ($this->collNavAccesses === null) {
            $this->initNavAccesses();
            $this->collNavAccessesPartial = true;
        }

        if (!$this->collNavAccesses->contains($l)) {
            $this->doAddNavAccess($l);

            if ($this->navAccessesScheduledForDeletion and $this->navAccessesScheduledForDeletion->contains($l)) {
                $this->navAccessesScheduledForDeletion->remove($this->navAccessesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param NavAccess $navAccess The NavAccess object to add.
     */
    protected function doAddNavAccess(NavAccess $navAccess)
    {
        $this->collNavAccesses[]= $navAccess;
        $navAccess->setRole($this);
    }

    /**
     * @param  NavAccess $navAccess The NavAccess object to remove.
     * @return $this|ChildRole The current object (for fluent API support)
     */
    public function removeNavAccess(NavAccess $navAccess)
    {
        if ($this->getNavAccesses()->contains($navAccess)) {
            $pos = $this->collNavAccesses->search($navAccess);
            $this->collNavAccesses->remove($pos);
            if (null === $this->navAccessesScheduledForDeletion) {
                $this->navAccessesScheduledForDeletion = clone $this->collNavAccesses;
                $this->navAccessesScheduledForDeletion->clear();
            }
            $this->navAccessesScheduledForDeletion[]= $navAccess;
            $navAccess->setRole(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Role is new, it will return
     * an empty collection; or if this Role has previously
     * been saved, it will retrieve related NavAccesses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Role.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|NavAccess[] List of NavAccess objects
     */
    public function getNavAccessesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = NavAccessQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getNavAccesses($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Role is new, it will return
     * an empty collection; or if this Role has previously
     * been saved, it will retrieve related NavAccesses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Role.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|NavAccess[] List of NavAccess objects
     */
    public function getNavAccessesJoinNav(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = NavAccessQuery::create(null, $criteria);
        $query->joinWith('Nav', $joinBehavior);

        return $this->getNavAccesses($query, $con);
    }

    /**
     * Clears out the collActivityAccesses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addActivityAccesses()
     */
    public function clearActivityAccesses()
    {
        $this->collActivityAccesses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collActivityAccesses collection loaded partially.
     */
    public function resetPartialActivityAccesses($v = true)
    {
        $this->collActivityAccessesPartial = $v;
    }

    /**
     * Initializes the collActivityAccesses collection.
     *
     * By default this just sets the collActivityAccesses collection to an empty array (like clearcollActivityAccesses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initActivityAccesses($overrideExisting = true)
    {
        if (null !== $this->collActivityAccesses && !$overrideExisting) {
            return;
        }

        $collectionClassName = ActivityAccessTableMap::getTableMap()->getCollectionClassName();

        $this->collActivityAccesses = new $collectionClassName;
        $this->collActivityAccesses->setModel('\Perfumerlabs\Start\Model\ActivityAccess');
    }

    /**
     * Gets an array of ActivityAccess objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRole is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ActivityAccess[] List of ActivityAccess objects
     * @throws PropelException
     */
    public function getActivityAccesses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collActivityAccessesPartial && !$this->isNew();
        if (null === $this->collActivityAccesses || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collActivityAccesses) {
                // return empty collection
                $this->initActivityAccesses();
            } else {
                $collActivityAccesses = ActivityAccessQuery::create(null, $criteria)
                    ->filterByRole($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collActivityAccessesPartial && count($collActivityAccesses)) {
                        $this->initActivityAccesses(false);

                        foreach ($collActivityAccesses as $obj) {
                            if (false == $this->collActivityAccesses->contains($obj)) {
                                $this->collActivityAccesses->append($obj);
                            }
                        }

                        $this->collActivityAccessesPartial = true;
                    }

                    return $collActivityAccesses;
                }

                if ($partial && $this->collActivityAccesses) {
                    foreach ($this->collActivityAccesses as $obj) {
                        if ($obj->isNew()) {
                            $collActivityAccesses[] = $obj;
                        }
                    }
                }

                $this->collActivityAccesses = $collActivityAccesses;
                $this->collActivityAccessesPartial = false;
            }
        }

        return $this->collActivityAccesses;
    }

    /**
     * Sets a collection of ActivityAccess objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $activityAccesses A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRole The current object (for fluent API support)
     */
    public function setActivityAccesses(Collection $activityAccesses, ConnectionInterface $con = null)
    {
        /** @var ActivityAccess[] $activityAccessesToDelete */
        $activityAccessesToDelete = $this->getActivityAccesses(new Criteria(), $con)->diff($activityAccesses);


        $this->activityAccessesScheduledForDeletion = $activityAccessesToDelete;

        foreach ($activityAccessesToDelete as $activityAccessRemoved) {
            $activityAccessRemoved->setRole(null);
        }

        $this->collActivityAccesses = null;
        foreach ($activityAccesses as $activityAccess) {
            $this->addActivityAccess($activityAccess);
        }

        $this->collActivityAccesses = $activityAccesses;
        $this->collActivityAccessesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseActivityAccess objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseActivityAccess objects.
     * @throws PropelException
     */
    public function countActivityAccesses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collActivityAccessesPartial && !$this->isNew();
        if (null === $this->collActivityAccesses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collActivityAccesses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getActivityAccesses());
            }

            $query = ActivityAccessQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRole($this)
                ->count($con);
        }

        return count($this->collActivityAccesses);
    }

    /**
     * Method called to associate a ActivityAccess object to this object
     * through the ActivityAccess foreign key attribute.
     *
     * @param  ActivityAccess $l ActivityAccess
     * @return $this|\App\Model\Role The current object (for fluent API support)
     */
    public function addActivityAccess(ActivityAccess $l)
    {
        if ($this->collActivityAccesses === null) {
            $this->initActivityAccesses();
            $this->collActivityAccessesPartial = true;
        }

        if (!$this->collActivityAccesses->contains($l)) {
            $this->doAddActivityAccess($l);

            if ($this->activityAccessesScheduledForDeletion and $this->activityAccessesScheduledForDeletion->contains($l)) {
                $this->activityAccessesScheduledForDeletion->remove($this->activityAccessesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ActivityAccess $activityAccess The ActivityAccess object to add.
     */
    protected function doAddActivityAccess(ActivityAccess $activityAccess)
    {
        $this->collActivityAccesses[]= $activityAccess;
        $activityAccess->setRole($this);
    }

    /**
     * @param  ActivityAccess $activityAccess The ActivityAccess object to remove.
     * @return $this|ChildRole The current object (for fluent API support)
     */
    public function removeActivityAccess(ActivityAccess $activityAccess)
    {
        if ($this->getActivityAccesses()->contains($activityAccess)) {
            $pos = $this->collActivityAccesses->search($activityAccess);
            $this->collActivityAccesses->remove($pos);
            if (null === $this->activityAccessesScheduledForDeletion) {
                $this->activityAccessesScheduledForDeletion = clone $this->collActivityAccesses;
                $this->activityAccessesScheduledForDeletion->clear();
            }
            $this->activityAccessesScheduledForDeletion[]= $activityAccess;
            $activityAccess->setRole(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Role is new, it will return
     * an empty collection; or if this Role has previously
     * been saved, it will retrieve related ActivityAccesses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Role.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ActivityAccess[] List of ActivityAccess objects
     */
    public function getActivityAccessesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ActivityAccessQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getActivityAccesses($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Role is new, it will return
     * an empty collection; or if this Role has previously
     * been saved, it will retrieve related ActivityAccesses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Role.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ActivityAccess[] List of ActivityAccess objects
     */
    public function getActivityAccessesJoinActivity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ActivityAccessQuery::create(null, $criteria);
        $query->joinWith('Activity', $joinBehavior);

        return $this->getActivityAccesses($query, $con);
    }

    /**
     * Clears out the collUsers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsers()
     */
    public function clearUsers()
    {
        $this->collUsers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collUsers crossRef collection.
     *
     * By default this just sets the collUsers collection to an empty collection (like clearUsers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initUsers()
    {
        $collectionClassName = UserRoleTableMap::getTableMap()->getCollectionClassName();

        $this->collUsers = new $collectionClassName;
        $this->collUsersPartial = true;
        $this->collUsers->setModel('\App\Model\User');
    }

    /**
     * Checks if the collUsers collection is loaded.
     *
     * @return bool
     */
    public function isUsersLoaded()
    {
        return null !== $this->collUsers;
    }

    /**
     * Gets a collection of ChildUser objects related by a many-to-many relationship
     * to the current object by way of the _user_role cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRole is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildUser[] List of ChildUser objects
     */
    public function getUsers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUsersPartial && !$this->isNew();
        if (null === $this->collUsers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collUsers) {
                    $this->initUsers();
                }
            } else {

                $query = ChildUserQuery::create(null, $criteria)
                    ->filterByRole($this);
                $collUsers = $query->find($con);
                if (null !== $criteria) {
                    return $collUsers;
                }

                if ($partial && $this->collUsers) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collUsers as $obj) {
                        if (!$collUsers->contains($obj)) {
                            $collUsers[] = $obj;
                        }
                    }
                }

                $this->collUsers = $collUsers;
                $this->collUsersPartial = false;
            }
        }

        return $this->collUsers;
    }

    /**
     * Sets a collection of User objects related by a many-to-many relationship
     * to the current object by way of the _user_role cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $users A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildRole The current object (for fluent API support)
     */
    public function setUsers(Collection $users, ConnectionInterface $con = null)
    {
        $this->clearUsers();
        $currentUsers = $this->getUsers();

        $usersScheduledForDeletion = $currentUsers->diff($users);

        foreach ($usersScheduledForDeletion as $toDelete) {
            $this->removeUser($toDelete);
        }

        foreach ($users as $user) {
            if (!$currentUsers->contains($user)) {
                $this->doAddUser($user);
            }
        }

        $this->collUsersPartial = false;
        $this->collUsers = $users;

        return $this;
    }

    /**
     * Gets the number of User objects related by a many-to-many relationship
     * to the current object by way of the _user_role cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related User objects
     */
    public function countUsers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUsersPartial && !$this->isNew();
        if (null === $this->collUsers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsers) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getUsers());
                }

                $query = ChildUserQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRole($this)
                    ->count($con);
            }
        } else {
            return count($this->collUsers);
        }
    }

    /**
     * Associate a ChildUser to this object
     * through the _user_role cross reference table.
     *
     * @param ChildUser $user
     * @return ChildRole The current object (for fluent API support)
     */
    public function addUser(ChildUser $user)
    {
        if ($this->collUsers === null) {
            $this->initUsers();
        }

        if (!$this->getUsers()->contains($user)) {
            // only add it if the **same** object is not already associated
            $this->collUsers->push($user);
            $this->doAddUser($user);
        }

        return $this;
    }

    /**
     *
     * @param ChildUser $user
     */
    protected function doAddUser(ChildUser $user)
    {
        $userRole = new ChildUserRole();

        $userRole->setUser($user);

        $userRole->setRole($this);

        $this->addUserRole($userRole);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$user->isRolesLoaded()) {
            $user->initRoles();
            $user->getRoles()->push($this);
        } elseif (!$user->getRoles()->contains($this)) {
            $user->getRoles()->push($this);
        }

    }

    /**
     * Remove user of this object
     * through the _user_role cross reference table.
     *
     * @param ChildUser $user
     * @return ChildRole The current object (for fluent API support)
     */
    public function removeUser(ChildUser $user)
    {
        if ($this->getUsers()->contains($user)) {
            $userRole = new ChildUserRole();
            $userRole->setUser($user);
            if ($user->isRolesLoaded()) {
                //remove the back reference if available
                $user->getRoles()->removeObject($this);
            }

            $userRole->setRole($this);
            $this->removeUserRole(clone $userRole);
            $userRole->clear();

            $this->collUsers->remove($this->collUsers->search($user));

            if (null === $this->usersScheduledForDeletion) {
                $this->usersScheduledForDeletion = clone $this->collUsers;
                $this->usersScheduledForDeletion->clear();
            }

            $this->usersScheduledForDeletion->push($user);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->permission = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collUserRoles) {
                foreach ($this->collUserRoles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collNavAccesses) {
                foreach ($this->collNavAccesses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collActivityAccesses) {
                foreach ($this->collActivityAccesses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsers) {
                foreach ($this->collUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collUserRoles = null;
        $this->collNavAccesses = null;
        $this->collActivityAccesses = null;
        $this->collUsers = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RoleTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
