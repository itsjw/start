<?php

namespace Perfumerlabs\Start\Model\Base;

use \Exception;
use \PDO;
use Perfumerlabs\Start\Model\Activity as ChildActivity;
use Perfumerlabs\Start\Model\ActivityAccess as ChildActivityAccess;
use Perfumerlabs\Start\Model\ActivityAccessQuery as ChildActivityAccessQuery;
use Perfumerlabs\Start\Model\ActivityQuery as ChildActivityQuery;
use Perfumerlabs\Start\Model\Duty as ChildDuty;
use Perfumerlabs\Start\Model\DutyQuery as ChildDutyQuery;
use Perfumerlabs\Start\Model\Nav as ChildNav;
use Perfumerlabs\Start\Model\NavQuery as ChildNavQuery;
use Perfumerlabs\Start\Model\Vendor as ChildVendor;
use Perfumerlabs\Start\Model\VendorQuery as ChildVendorQuery;
use Perfumerlabs\Start\Model\Map\ActivityAccessTableMap;
use Perfumerlabs\Start\Model\Map\ActivityTableMap;
use Perfumerlabs\Start\Model\Map\DutyTableMap;
use Perfumerlabs\Start\Model\Map\NavTableMap;
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
 * Base class that represents a row from the 'activity' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Activity implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Perfumerlabs\\Start\\Model\\Map\\ActivityTableMap';


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
     * The value for the code field.
     *
     * @var        string
     */
    protected $code;

    /**
     * The value for the readonly field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $readonly;

    /**
     * The value for the writable field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $writable;

    /**
     * The value for the postponable field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $postponable;

    /**
     * The value for the color field.
     *
     * @var        string
     */
    protected $color;

    /**
     * The value for the priority field.
     *
     * @var        int
     */
    protected $priority;

    /**
     * The value for the vendor_id field.
     *
     * @var        int
     */
    protected $vendor_id;

    /**
     * @var        ChildVendor
     */
    protected $aVendor;

    /**
     * @var        ObjectCollection|ChildDuty[] Collection to store aggregation of ChildDuty objects.
     */
    protected $collDuties;
    protected $collDutiesPartial;

    /**
     * @var        ObjectCollection|ChildNav[] Collection to store aggregation of ChildNav objects.
     */
    protected $collNavs;
    protected $collNavsPartial;

    /**
     * @var        ObjectCollection|ChildActivityAccess[] Collection to store aggregation of ChildActivityAccess objects.
     */
    protected $collActivityAccesses;
    protected $collActivityAccessesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDuty[]
     */
    protected $dutiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildNav[]
     */
    protected $navsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildActivityAccess[]
     */
    protected $activityAccessesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->readonly = false;
        $this->writable = false;
        $this->postponable = false;
    }

    /**
     * Initializes internal state of Perfumerlabs\Start\Model\Base\Activity object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Activity</code> instance.  If
     * <code>obj</code> is an instance of <code>Activity</code>, delegates to
     * <code>equals(Activity)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Activity The current object, for fluid interface
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
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the [readonly] column value.
     *
     * @return boolean
     */
    public function getReadonly()
    {
        return $this->readonly;
    }

    /**
     * Get the [readonly] column value.
     *
     * @return boolean
     */
    public function isReadonly()
    {
        return $this->getReadonly();
    }

    /**
     * Get the [writable] column value.
     *
     * @return boolean
     */
    public function getWritable()
    {
        return $this->writable;
    }

    /**
     * Get the [writable] column value.
     *
     * @return boolean
     */
    public function isWritable()
    {
        return $this->getWritable();
    }

    /**
     * Get the [postponable] column value.
     *
     * @return boolean
     */
    public function getPostponable()
    {
        return $this->postponable;
    }

    /**
     * Get the [postponable] column value.
     *
     * @return boolean
     */
    public function isPostponable()
    {
        return $this->getPostponable();
    }

    /**
     * Get the [color] column value.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get the [priority] column value.
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get the [vendor_id] column value.
     *
     * @return int
     */
    public function getVendorId()
    {
        return $this->vendor_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ActivityTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ActivityTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [code] column.
     *
     * @param string $v new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[ActivityTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Sets the value of the [readonly] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setReadonly($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->readonly !== $v) {
            $this->readonly = $v;
            $this->modifiedColumns[ActivityTableMap::COL_READONLY] = true;
        }

        return $this;
    } // setReadonly()

    /**
     * Sets the value of the [writable] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setWritable($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->writable !== $v) {
            $this->writable = $v;
            $this->modifiedColumns[ActivityTableMap::COL_WRITABLE] = true;
        }

        return $this;
    } // setWritable()

    /**
     * Sets the value of the [postponable] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setPostponable($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->postponable !== $v) {
            $this->postponable = $v;
            $this->modifiedColumns[ActivityTableMap::COL_POSTPONABLE] = true;
        }

        return $this;
    } // setPostponable()

    /**
     * Set the value of [color] column.
     *
     * @param string $v new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setColor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->color !== $v) {
            $this->color = $v;
            $this->modifiedColumns[ActivityTableMap::COL_COLOR] = true;
        }

        return $this;
    } // setColor()

    /**
     * Set the value of [priority] column.
     *
     * @param int $v new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setPriority($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->priority !== $v) {
            $this->priority = $v;
            $this->modifiedColumns[ActivityTableMap::COL_PRIORITY] = true;
        }

        return $this;
    } // setPriority()

    /**
     * Set the value of [vendor_id] column.
     *
     * @param int $v new value
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function setVendorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->vendor_id !== $v) {
            $this->vendor_id = $v;
            $this->modifiedColumns[ActivityTableMap::COL_VENDOR_ID] = true;
        }

        if ($this->aVendor !== null && $this->aVendor->getId() !== $v) {
            $this->aVendor = null;
        }

        return $this;
    } // setVendorId()

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
            if ($this->readonly !== false) {
                return false;
            }

            if ($this->writable !== false) {
                return false;
            }

            if ($this->postponable !== false) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ActivityTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ActivityTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ActivityTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ActivityTableMap::translateFieldName('Readonly', TableMap::TYPE_PHPNAME, $indexType)];
            $this->readonly = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ActivityTableMap::translateFieldName('Writable', TableMap::TYPE_PHPNAME, $indexType)];
            $this->writable = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ActivityTableMap::translateFieldName('Postponable', TableMap::TYPE_PHPNAME, $indexType)];
            $this->postponable = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ActivityTableMap::translateFieldName('Color', TableMap::TYPE_PHPNAME, $indexType)];
            $this->color = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ActivityTableMap::translateFieldName('Priority', TableMap::TYPE_PHPNAME, $indexType)];
            $this->priority = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ActivityTableMap::translateFieldName('VendorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->vendor_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = ActivityTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Perfumerlabs\\Start\\Model\\Activity'), 0, $e);
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
        if ($this->aVendor !== null && $this->vendor_id !== $this->aVendor->getId()) {
            $this->aVendor = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(ActivityTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildActivityQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aVendor = null;
            $this->collDuties = null;

            $this->collNavs = null;

            $this->collActivityAccesses = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Activity::setDeleted()
     * @see Activity::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ActivityTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildActivityQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ActivityTableMap::DATABASE_NAME);
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
                ActivityTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aVendor !== null) {
                if ($this->aVendor->isModified() || $this->aVendor->isNew()) {
                    $affectedRows += $this->aVendor->save($con);
                }
                $this->setVendor($this->aVendor);
            }

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

            if ($this->dutiesScheduledForDeletion !== null) {
                if (!$this->dutiesScheduledForDeletion->isEmpty()) {
                    foreach ($this->dutiesScheduledForDeletion as $duty) {
                        // need to save related object because we set the relation to null
                        $duty->save($con);
                    }
                    $this->dutiesScheduledForDeletion = null;
                }
            }

            if ($this->collDuties !== null) {
                foreach ($this->collDuties as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->navsScheduledForDeletion !== null) {
                if (!$this->navsScheduledForDeletion->isEmpty()) {
                    foreach ($this->navsScheduledForDeletion as $nav) {
                        // need to save related object because we set the relation to null
                        $nav->save($con);
                    }
                    $this->navsScheduledForDeletion = null;
                }
            }

            if ($this->collNavs !== null) {
                foreach ($this->collNavs as $referrerFK) {
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

        $this->modifiedColumns[ActivityTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ActivityTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('activity_id_seq')");
                $this->id = (int) $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ActivityTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ActivityTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(ActivityTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(ActivityTableMap::COL_READONLY)) {
            $modifiedColumns[':p' . $index++]  = 'readonly';
        }
        if ($this->isColumnModified(ActivityTableMap::COL_WRITABLE)) {
            $modifiedColumns[':p' . $index++]  = 'writable';
        }
        if ($this->isColumnModified(ActivityTableMap::COL_POSTPONABLE)) {
            $modifiedColumns[':p' . $index++]  = 'postponable';
        }
        if ($this->isColumnModified(ActivityTableMap::COL_COLOR)) {
            $modifiedColumns[':p' . $index++]  = 'color';
        }
        if ($this->isColumnModified(ActivityTableMap::COL_PRIORITY)) {
            $modifiedColumns[':p' . $index++]  = 'priority';
        }
        if ($this->isColumnModified(ActivityTableMap::COL_VENDOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'vendor_id';
        }

        $sql = sprintf(
            'INSERT INTO activity (%s) VALUES (%s)',
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
                    case 'code':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case 'readonly':
                        $stmt->bindValue($identifier, $this->readonly, PDO::PARAM_BOOL);
                        break;
                    case 'writable':
                        $stmt->bindValue($identifier, $this->writable, PDO::PARAM_BOOL);
                        break;
                    case 'postponable':
                        $stmt->bindValue($identifier, $this->postponable, PDO::PARAM_BOOL);
                        break;
                    case 'color':
                        $stmt->bindValue($identifier, $this->color, PDO::PARAM_STR);
                        break;
                    case 'priority':
                        $stmt->bindValue($identifier, $this->priority, PDO::PARAM_INT);
                        break;
                    case 'vendor_id':
                        $stmt->bindValue($identifier, $this->vendor_id, PDO::PARAM_INT);
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
        $pos = ActivityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCode();
                break;
            case 3:
                return $this->getReadonly();
                break;
            case 4:
                return $this->getWritable();
                break;
            case 5:
                return $this->getPostponable();
                break;
            case 6:
                return $this->getColor();
                break;
            case 7:
                return $this->getPriority();
                break;
            case 8:
                return $this->getVendorId();
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

        if (isset($alreadyDumpedObjects['Activity'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Activity'][$this->hashCode()] = true;
        $keys = ActivityTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getCode(),
            $keys[3] => $this->getReadonly(),
            $keys[4] => $this->getWritable(),
            $keys[5] => $this->getPostponable(),
            $keys[6] => $this->getColor(),
            $keys[7] => $this->getPriority(),
            $keys[8] => $this->getVendorId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aVendor) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'vendor';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'vendor';
                        break;
                    default:
                        $key = 'Vendor';
                }

                $result[$key] = $this->aVendor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collDuties) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'duties';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'duties';
                        break;
                    default:
                        $key = 'Duties';
                }

                $result[$key] = $this->collDuties->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collNavs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'navs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'navs';
                        break;
                    default:
                        $key = 'Navs';
                }

                $result[$key] = $this->collNavs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Perfumerlabs\Start\Model\Activity
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ActivityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Perfumerlabs\Start\Model\Activity
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
                $this->setCode($value);
                break;
            case 3:
                $this->setReadonly($value);
                break;
            case 4:
                $this->setWritable($value);
                break;
            case 5:
                $this->setPostponable($value);
                break;
            case 6:
                $this->setColor($value);
                break;
            case 7:
                $this->setPriority($value);
                break;
            case 8:
                $this->setVendorId($value);
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
        $keys = ActivityTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCode($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setReadonly($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setWritable($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPostponable($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setColor($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPriority($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setVendorId($arr[$keys[8]]);
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
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object, for fluid interface
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
        $criteria = new Criteria(ActivityTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ActivityTableMap::COL_ID)) {
            $criteria->add(ActivityTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ActivityTableMap::COL_NAME)) {
            $criteria->add(ActivityTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ActivityTableMap::COL_CODE)) {
            $criteria->add(ActivityTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(ActivityTableMap::COL_READONLY)) {
            $criteria->add(ActivityTableMap::COL_READONLY, $this->readonly);
        }
        if ($this->isColumnModified(ActivityTableMap::COL_WRITABLE)) {
            $criteria->add(ActivityTableMap::COL_WRITABLE, $this->writable);
        }
        if ($this->isColumnModified(ActivityTableMap::COL_POSTPONABLE)) {
            $criteria->add(ActivityTableMap::COL_POSTPONABLE, $this->postponable);
        }
        if ($this->isColumnModified(ActivityTableMap::COL_COLOR)) {
            $criteria->add(ActivityTableMap::COL_COLOR, $this->color);
        }
        if ($this->isColumnModified(ActivityTableMap::COL_PRIORITY)) {
            $criteria->add(ActivityTableMap::COL_PRIORITY, $this->priority);
        }
        if ($this->isColumnModified(ActivityTableMap::COL_VENDOR_ID)) {
            $criteria->add(ActivityTableMap::COL_VENDOR_ID, $this->vendor_id);
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
        $criteria = ChildActivityQuery::create();
        $criteria->add(ActivityTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Perfumerlabs\Start\Model\Activity (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setCode($this->getCode());
        $copyObj->setReadonly($this->getReadonly());
        $copyObj->setWritable($this->getWritable());
        $copyObj->setPostponable($this->getPostponable());
        $copyObj->setColor($this->getColor());
        $copyObj->setPriority($this->getPriority());
        $copyObj->setVendorId($this->getVendorId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDuties() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDuty($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getNavs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addNav($relObj->copy($deepCopy));
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
     * @return \Perfumerlabs\Start\Model\Activity Clone of current object.
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
     * Declares an association between this object and a ChildVendor object.
     *
     * @param  ChildVendor $v
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     * @throws PropelException
     */
    public function setVendor(ChildVendor $v = null)
    {
        if ($v === null) {
            $this->setVendorId(NULL);
        } else {
            $this->setVendorId($v->getId());
        }

        $this->aVendor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildVendor object, it will not be re-added.
        if ($v !== null) {
            $v->addActivity($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildVendor object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildVendor The associated ChildVendor object.
     * @throws PropelException
     */
    public function getVendor(ConnectionInterface $con = null)
    {
        if ($this->aVendor === null && ($this->vendor_id !== null)) {
            $this->aVendor = ChildVendorQuery::create()->findPk($this->vendor_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aVendor->addActivities($this);
             */
        }

        return $this->aVendor;
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
        if ('Duty' == $relationName) {
            return $this->initDuties();
        }
        if ('Nav' == $relationName) {
            return $this->initNavs();
        }
        if ('ActivityAccess' == $relationName) {
            return $this->initActivityAccesses();
        }
    }

    /**
     * Clears out the collDuties collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDuties()
     */
    public function clearDuties()
    {
        $this->collDuties = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDuties collection loaded partially.
     */
    public function resetPartialDuties($v = true)
    {
        $this->collDutiesPartial = $v;
    }

    /**
     * Initializes the collDuties collection.
     *
     * By default this just sets the collDuties collection to an empty array (like clearcollDuties());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDuties($overrideExisting = true)
    {
        if (null !== $this->collDuties && !$overrideExisting) {
            return;
        }

        $collectionClassName = DutyTableMap::getTableMap()->getCollectionClassName();

        $this->collDuties = new $collectionClassName;
        $this->collDuties->setModel('\Perfumerlabs\Start\Model\Duty');
    }

    /**
     * Gets an array of ChildDuty objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildActivity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDuty[] List of ChildDuty objects
     * @throws PropelException
     */
    public function getDuties(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDutiesPartial && !$this->isNew();
        if (null === $this->collDuties || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDuties) {
                // return empty collection
                $this->initDuties();
            } else {
                $collDuties = ChildDutyQuery::create(null, $criteria)
                    ->filterByActivity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDutiesPartial && count($collDuties)) {
                        $this->initDuties(false);

                        foreach ($collDuties as $obj) {
                            if (false == $this->collDuties->contains($obj)) {
                                $this->collDuties->append($obj);
                            }
                        }

                        $this->collDutiesPartial = true;
                    }

                    return $collDuties;
                }

                if ($partial && $this->collDuties) {
                    foreach ($this->collDuties as $obj) {
                        if ($obj->isNew()) {
                            $collDuties[] = $obj;
                        }
                    }
                }

                $this->collDuties = $collDuties;
                $this->collDutiesPartial = false;
            }
        }

        return $this->collDuties;
    }

    /**
     * Sets a collection of ChildDuty objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $duties A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildActivity The current object (for fluent API support)
     */
    public function setDuties(Collection $duties, ConnectionInterface $con = null)
    {
        /** @var ChildDuty[] $dutiesToDelete */
        $dutiesToDelete = $this->getDuties(new Criteria(), $con)->diff($duties);


        $this->dutiesScheduledForDeletion = $dutiesToDelete;

        foreach ($dutiesToDelete as $dutyRemoved) {
            $dutyRemoved->setActivity(null);
        }

        $this->collDuties = null;
        foreach ($duties as $duty) {
            $this->addDuty($duty);
        }

        $this->collDuties = $duties;
        $this->collDutiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Duty objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Duty objects.
     * @throws PropelException
     */
    public function countDuties(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDutiesPartial && !$this->isNew();
        if (null === $this->collDuties || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDuties) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDuties());
            }

            $query = ChildDutyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByActivity($this)
                ->count($con);
        }

        return count($this->collDuties);
    }

    /**
     * Method called to associate a ChildDuty object to this object
     * through the ChildDuty foreign key attribute.
     *
     * @param  ChildDuty $l ChildDuty
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function addDuty(ChildDuty $l)
    {
        if ($this->collDuties === null) {
            $this->initDuties();
            $this->collDutiesPartial = true;
        }

        if (!$this->collDuties->contains($l)) {
            $this->doAddDuty($l);

            if ($this->dutiesScheduledForDeletion and $this->dutiesScheduledForDeletion->contains($l)) {
                $this->dutiesScheduledForDeletion->remove($this->dutiesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDuty $duty The ChildDuty object to add.
     */
    protected function doAddDuty(ChildDuty $duty)
    {
        $this->collDuties[]= $duty;
        $duty->setActivity($this);
    }

    /**
     * @param  ChildDuty $duty The ChildDuty object to remove.
     * @return $this|ChildActivity The current object (for fluent API support)
     */
    public function removeDuty(ChildDuty $duty)
    {
        if ($this->getDuties()->contains($duty)) {
            $pos = $this->collDuties->search($duty);
            $this->collDuties->remove($pos);
            if (null === $this->dutiesScheduledForDeletion) {
                $this->dutiesScheduledForDeletion = clone $this->collDuties;
                $this->dutiesScheduledForDeletion->clear();
            }
            $this->dutiesScheduledForDeletion[]= $duty;
            $duty->setActivity(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Activity is new, it will return
     * an empty collection; or if this Activity has previously
     * been saved, it will retrieve related Duties from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Activity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDuty[] List of ChildDuty objects
     */
    public function getDutiesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDutyQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getDuties($query, $con);
    }

    /**
     * Clears out the collNavs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addNavs()
     */
    public function clearNavs()
    {
        $this->collNavs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collNavs collection loaded partially.
     */
    public function resetPartialNavs($v = true)
    {
        $this->collNavsPartial = $v;
    }

    /**
     * Initializes the collNavs collection.
     *
     * By default this just sets the collNavs collection to an empty array (like clearcollNavs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initNavs($overrideExisting = true)
    {
        if (null !== $this->collNavs && !$overrideExisting) {
            return;
        }

        $collectionClassName = NavTableMap::getTableMap()->getCollectionClassName();

        $this->collNavs = new $collectionClassName;
        $this->collNavs->setModel('\Perfumerlabs\Start\Model\Nav');
    }

    /**
     * Gets an array of ChildNav objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildActivity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildNav[] List of ChildNav objects
     * @throws PropelException
     */
    public function getNavs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collNavsPartial && !$this->isNew();
        if (null === $this->collNavs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collNavs) {
                // return empty collection
                $this->initNavs();
            } else {
                $collNavs = ChildNavQuery::create(null, $criteria)
                    ->filterByActivity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collNavsPartial && count($collNavs)) {
                        $this->initNavs(false);

                        foreach ($collNavs as $obj) {
                            if (false == $this->collNavs->contains($obj)) {
                                $this->collNavs->append($obj);
                            }
                        }

                        $this->collNavsPartial = true;
                    }

                    return $collNavs;
                }

                if ($partial && $this->collNavs) {
                    foreach ($this->collNavs as $obj) {
                        if ($obj->isNew()) {
                            $collNavs[] = $obj;
                        }
                    }
                }

                $this->collNavs = $collNavs;
                $this->collNavsPartial = false;
            }
        }

        return $this->collNavs;
    }

    /**
     * Sets a collection of ChildNav objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $navs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildActivity The current object (for fluent API support)
     */
    public function setNavs(Collection $navs, ConnectionInterface $con = null)
    {
        /** @var ChildNav[] $navsToDelete */
        $navsToDelete = $this->getNavs(new Criteria(), $con)->diff($navs);


        $this->navsScheduledForDeletion = $navsToDelete;

        foreach ($navsToDelete as $navRemoved) {
            $navRemoved->setActivity(null);
        }

        $this->collNavs = null;
        foreach ($navs as $nav) {
            $this->addNav($nav);
        }

        $this->collNavs = $navs;
        $this->collNavsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Nav objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Nav objects.
     * @throws PropelException
     */
    public function countNavs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collNavsPartial && !$this->isNew();
        if (null === $this->collNavs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collNavs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getNavs());
            }

            $query = ChildNavQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByActivity($this)
                ->count($con);
        }

        return count($this->collNavs);
    }

    /**
     * Method called to associate a ChildNav object to this object
     * through the ChildNav foreign key attribute.
     *
     * @param  ChildNav $l ChildNav
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function addNav(ChildNav $l)
    {
        if ($this->collNavs === null) {
            $this->initNavs();
            $this->collNavsPartial = true;
        }

        if (!$this->collNavs->contains($l)) {
            $this->doAddNav($l);

            if ($this->navsScheduledForDeletion and $this->navsScheduledForDeletion->contains($l)) {
                $this->navsScheduledForDeletion->remove($this->navsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildNav $nav The ChildNav object to add.
     */
    protected function doAddNav(ChildNav $nav)
    {
        $this->collNavs[]= $nav;
        $nav->setActivity($this);
    }

    /**
     * @param  ChildNav $nav The ChildNav object to remove.
     * @return $this|ChildActivity The current object (for fluent API support)
     */
    public function removeNav(ChildNav $nav)
    {
        if ($this->getNavs()->contains($nav)) {
            $pos = $this->collNavs->search($nav);
            $this->collNavs->remove($pos);
            if (null === $this->navsScheduledForDeletion) {
                $this->navsScheduledForDeletion = clone $this->collNavs;
                $this->navsScheduledForDeletion->clear();
            }
            $this->navsScheduledForDeletion[]= $nav;
            $nav->setActivity(null);
        }

        return $this;
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
     * Gets an array of ChildActivityAccess objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildActivity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildActivityAccess[] List of ChildActivityAccess objects
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
                $collActivityAccesses = ChildActivityAccessQuery::create(null, $criteria)
                    ->filterByActivity($this)
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
     * Sets a collection of ChildActivityAccess objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $activityAccesses A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildActivity The current object (for fluent API support)
     */
    public function setActivityAccesses(Collection $activityAccesses, ConnectionInterface $con = null)
    {
        /** @var ChildActivityAccess[] $activityAccessesToDelete */
        $activityAccessesToDelete = $this->getActivityAccesses(new Criteria(), $con)->diff($activityAccesses);


        $this->activityAccessesScheduledForDeletion = $activityAccessesToDelete;

        foreach ($activityAccessesToDelete as $activityAccessRemoved) {
            $activityAccessRemoved->setActivity(null);
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
     * Returns the number of related ActivityAccess objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ActivityAccess objects.
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

            $query = ChildActivityAccessQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByActivity($this)
                ->count($con);
        }

        return count($this->collActivityAccesses);
    }

    /**
     * Method called to associate a ChildActivityAccess object to this object
     * through the ChildActivityAccess foreign key attribute.
     *
     * @param  ChildActivityAccess $l ChildActivityAccess
     * @return $this|\Perfumerlabs\Start\Model\Activity The current object (for fluent API support)
     */
    public function addActivityAccess(ChildActivityAccess $l)
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
     * @param ChildActivityAccess $activityAccess The ChildActivityAccess object to add.
     */
    protected function doAddActivityAccess(ChildActivityAccess $activityAccess)
    {
        $this->collActivityAccesses[]= $activityAccess;
        $activityAccess->setActivity($this);
    }

    /**
     * @param  ChildActivityAccess $activityAccess The ChildActivityAccess object to remove.
     * @return $this|ChildActivity The current object (for fluent API support)
     */
    public function removeActivityAccess(ChildActivityAccess $activityAccess)
    {
        if ($this->getActivityAccesses()->contains($activityAccess)) {
            $pos = $this->collActivityAccesses->search($activityAccess);
            $this->collActivityAccesses->remove($pos);
            if (null === $this->activityAccessesScheduledForDeletion) {
                $this->activityAccessesScheduledForDeletion = clone $this->collActivityAccesses;
                $this->activityAccessesScheduledForDeletion->clear();
            }
            $this->activityAccessesScheduledForDeletion[]= clone $activityAccess;
            $activityAccess->setActivity(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Activity is new, it will return
     * an empty collection; or if this Activity has previously
     * been saved, it will retrieve related ActivityAccesses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Activity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildActivityAccess[] List of ChildActivityAccess objects
     */
    public function getActivityAccessesJoinRole(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildActivityAccessQuery::create(null, $criteria);
        $query->joinWith('Role', $joinBehavior);

        return $this->getActivityAccesses($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Activity is new, it will return
     * an empty collection; or if this Activity has previously
     * been saved, it will retrieve related ActivityAccesses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Activity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildActivityAccess[] List of ChildActivityAccess objects
     */
    public function getActivityAccessesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildActivityAccessQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getActivityAccesses($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aVendor) {
            $this->aVendor->removeActivity($this);
        }
        $this->id = null;
        $this->name = null;
        $this->code = null;
        $this->readonly = null;
        $this->writable = null;
        $this->postponable = null;
        $this->color = null;
        $this->priority = null;
        $this->vendor_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collDuties) {
                foreach ($this->collDuties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collNavs) {
                foreach ($this->collNavs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collActivityAccesses) {
                foreach ($this->collActivityAccesses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDuties = null;
        $this->collNavs = null;
        $this->collActivityAccesses = null;
        $this->aVendor = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ActivityTableMap::DEFAULT_STRING_FORMAT);
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
