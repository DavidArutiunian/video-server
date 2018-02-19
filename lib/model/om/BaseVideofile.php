<?php

abstract class BaseVideoFile extends BaseObject implements Persistent
{
    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        VideoFilePeer
     */
    protected static $peer;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the type field.
     * @var        string
     */
    protected $type;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    const PEER = 'VideoFilePeer';

    /**
     * Get the [id] column value.
     *
     * @return     int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [type] column value.
     *
     * @return     string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [url] column value.
     *
     * @return     string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the [title] column value.
     *
     * @return     string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [description] column value.
     *
     * @return     string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     * @return     string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     * @throws     PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = 'Y-m-d H:i:s')
    {
        if ($this->created_at === null) {
            return null;
        }


        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of NULL,
            // this seems to be closest in meaning.
            return null;
        } else {
            try {
                $dt = new DateTime($this->created_at);
            } catch (Exception $x) {
                throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
            }
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is TRUE, we return a DateTime object.
            return $dt;
        } elseif (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        } else {
            return $dt->format($format);
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     * @return     string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     * @throws     PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = 'Y-m-d H:i:s')
    {
        if ($this->updated_at === null) {
            return null;
        }


        if ($this->updated_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of NULL,
            // this seems to be closest in meaning.
            return null;
        } else {
            try {
                $dt = new DateTime($this->updated_at);
            } catch (Exception $x) {
                throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
            }
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is TRUE, we return a DateTime object.
            return $dt;
        } elseif (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        } else {
            return $dt->format($format);
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return BaseVideoFile
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = VideoFilePeer::ID;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [type] column.
     *
     * @param      string $v new value
     * @return BaseVideoFile
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = VideoFilePeer::TYPE;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [url] column.
     *
     * @param      string $v new value
     * @return BaseVideoFile
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[] = VideoFilePeer::URL;
        }

        return $this;
    } // setUrl()

    /**
     * Set the value of [title] column.
     *
     * @param      string $v new value
     * @return BaseVideoFile
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = VideoFilePeer::TITLE;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [description] column.
     *
     * @param      string $v new value
     * @return BaseVideoFile
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = VideoFilePeer::DESCRIPTION;
        }

        return $this;
    } // setDescription()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
     *                        be treated as NULL for temporal objects.
     * @return BaseVideoFile
     * @throws PropelException
     */
    public function setCreatedAt($v)
    {
        // we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
        // -- which is unexpected, to say the least.
        if ($v === null || $v === '') {
            $dt = null;
        } elseif ($v instanceof DateTime) {
            $dt = $v;
        } else {
            // some string/numeric value passed; we normalize that so that we can
            // validate it.
            try {
                if (is_numeric($v)) { // if it's a unix timestamp
                    $dt = new DateTime('@' . $v, new DateTimeZone('UTC'));
                    // We have to explicitly specify and then change the time zone because of a
                    // DateTime bug: http://bugs.php.net/bug.php?id=43003
                    $dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
                } else {
                    $dt = new DateTime($v);
                }
            } catch (Exception $x) {
                throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
            }
        }

        if ($this->created_at !== null || $dt !== null) {
            // (nested ifs are a little easier to read in this case)

            $currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

            if (($currNorm !== $newNorm) // normalized values don't match
            ) {
                $this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
                $this->modifiedColumns[] = VideoFilePeer::CREATED_AT;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
     *                        be treated as NULL for temporal objects.
     * @return BaseVideoFile
     * @throws PropelException
     */
    public function setUpdatedAt($v)
    {
        // we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
        // -- which is unexpected, to say the least.
        if ($v === null || $v === '') {
            $dt = null;
        } elseif ($v instanceof DateTime) {
            $dt = $v;
        } else {
            // some string/numeric value passed; we normalize that so that we can
            // validate it.
            try {
                if (is_numeric($v)) { // if it's a unix timestamp
                    $dt = new DateTime('@' . $v, new DateTimeZone('UTC'));
                    // We have to explicitly specify and then change the time zone because of a
                    // DateTime bug: http://bugs.php.net/bug.php?id=43003
                    $dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
                } else {
                    $dt = new DateTime($v);
                }
            } catch (Exception $x) {
                throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
            }
        }

        if ($this->updated_at !== null || $dt !== null) {
            // (nested ifs are a little easier to read in this case)

            $currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

            if (($currNorm !== $newNorm) // normalized values don't match
            ) {
                $this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
                $this->modifiedColumns[] = VideoFilePeer::UPDATED_AT;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return     boolean Whether the columns in this object are only been set with default values.
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
     * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return     int next starting column
     * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int)$row[$startcol + 0] : null;
            $this->type = ($row[$startcol + 1] !== null) ? (string)$row[$startcol + 1] : null;
            $this->url = ($row[$startcol + 2] !== null) ? (string)$row[$startcol + 2] : null;
            $this->title = ($row[$startcol + 3] !== null) ? (string)$row[$startcol + 3] : null;
            $this->description = ($row[$startcol + 4] !== null) ? (string)$row[$startcol + 4] : null;
            $this->created_at = ($row[$startcol + 5] !== null) ? (string)$row[$startcol + 5] : null;
            $this->updated_at = ($row[$startcol + 6] !== null) ? (string)$row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            // FIXME - using NUM_COLUMNS may be clearer.
            return $startcol + 7; // 7 = VideoFilePeer::NUM_COLUMNS - VideoFilePeer::NUM_LAZY_LOAD_COLUMNS).

        } catch (Exception $e) {
            throw new PropelException("Error populating Videofile object", $e);
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
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to de-associate any related objects.
     * @param      PropelPDO $con (optional) The PropelPDO connection to use.
     * @return     void
     * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(VideoFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = VideoFilePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      PropelPDO $con
     * @return     void
     * @throws     PropelException
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(VideoFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $ret = $this->preDelete($con);
            foreach (sfMixer::getCallables('BaseVideoFile:delete:pre') as $callable) {
                if ($ret = call_user_func($callable, $this, $con)) {
                    return;
                }
            }

            if ($ret) {
                VideoFilePeer::doDelete($this, $con);
                $this->postDelete($con);
                foreach (sfMixer::getCallables('BaseVideoFile:delete:post') as $callable) {
                    call_user_func($callable, $this, $con);
                }

                $this->setDeleted(true);
                $con->commit();
            }
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      PropelPDO $con
     * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws     PropelException
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(VideoFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            foreach (sfMixer::getCallables('BaseVideoFile:save:pre') as $callable) {
                if (is_integer($affectedRows = call_user_func($callable, $this, $con))) {
                    return $affectedRows;
                }
            }
            if ($this->isModified() && !$this->isColumnModified(VideoFilePeer::UPDATED_AT)) {
                $this->setUpdatedAt(time());
            }

            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                if (!$this->isColumnModified(VideoFilePeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }

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
                foreach (sfMixer::getCallables('BaseVideoFile:save:post') as $callable) {
                    call_user_func($callable, $this, $con, $affectedRows);
                }

                $con->commit();
                VideoFilePeer::addInstanceToPool($this);
                return $affectedRows;
            }
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
        return 0;
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      PropelPDO $con
     * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws     PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew()) {
                $this->modifiedColumns[] = VideoFilePeer::ID;
            }

            // If this object has been modified, then save it to the database.
            if ($this->isModified()) {
                if ($this->isNew()) {
                    $pk = VideoFilePeer::doInsert($this, $con);
                    $affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
                    // should always be true here (even though technically
                    // BasePeer::doInsert() can insert multiple rows).

                    $this->setId($pk);  //[IMV] update autoincrement primary key

                    $this->setNew(false);
                } else {
                    $affectedRows += VideoFilePeer::doUpdate($this, $con);
                }

                $this->resetModified(); // [HL] After being saved an object is no longer 'modified'
            }

            $this->alreadyInSave = false;

        }
        return $affectedRows;
    } // doSave()

    /**
     * Array of ValidationFailed objects.
     * @var        ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return     ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param      mixed $columns Column name or an array of column names.
     * @return     boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     * @throws PropelException
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();
            return true;
        } else {
            $this->validationFailures = $res;
            return false;
        }
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param      array $columns Array of column names to validate.
     * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     * @throws PropelException
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();

            if (($retval = VideoFilePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }

            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return     mixed Value of field.
     * @throws PropelException
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = VideoFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);
        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return     mixed Value of field at $pos
     * @throws PropelException
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getType();
                break;
            case 2:
                return $this->getUrl();
                break;
            case 3:
                return $this->getTitle();
                break;
            case 4:
                return $this->getDescription();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
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
     * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
     * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
     * @return     array an associative array containing the field names (as keys) and field values
     * @throws PropelException
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
    {
        $keys = VideoFilePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getType(),
            $keys[2] => $this->getUrl(),
            $keys[3] => $this->getTitle(),
            $keys[4] => $this->getDescription(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name peer name
     * @param      mixed $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return     void
     * @throws PropelException
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = VideoFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        try {
            $this->setByPosition($pos, $value);
        } catch (PropelException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return     void
     * @throws PropelException
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setType($value);
                break;
            case 2:
                $this->setUrl($value);
                break;
            case 3:
                $this->setTitle($value);
                break;
            case 4:
                $this->setDescription($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
        } // switch()
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
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's phpname (e.g. 'AuthorId')
     *
     * @param      array $arr An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return     void
     * @throws PropelException
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = VideoFilePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setType($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUrl($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setTitle($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return     Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(VideoFilePeer::DATABASE_NAME);

        if ($this->isColumnModified(VideoFilePeer::ID)) $criteria->add(VideoFilePeer::ID, $this->id);
        if ($this->isColumnModified(VideoFilePeer::TYPE)) $criteria->add(VideoFilePeer::TYPE, $this->type);
        if ($this->isColumnModified(VideoFilePeer::URL)) $criteria->add(VideoFilePeer::URL, $this->url);
        if ($this->isColumnModified(VideoFilePeer::TITLE)) $criteria->add(VideoFilePeer::TITLE, $this->title);
        if ($this->isColumnModified(VideoFilePeer::DESCRIPTION)) $criteria->add(VideoFilePeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(VideoFilePeer::CREATED_AT)) $criteria->add(VideoFilePeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(VideoFilePeer::UPDATED_AT)) $criteria->add(VideoFilePeer::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return     Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(VideoFilePeer::DATABASE_NAME);

        $criteria->add(VideoFilePeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return     int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param      int $key Primary key.
     * @return     void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of VideoFile (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     */
    public function copyInto($copyObj, $deepCopy = false)
    {
        $copyObj->setType($this->type);
        $copyObj->setUrl($this->url);
        $copyObj->setTitle($this->title);
        $copyObj->setDescription($this->description);
        $copyObj->setCreatedAt($this->created_at);
        $copyObj->setUpdatedAt($this->updated_at);

        $copyObj->setNew(true);

        $copyObj->setId(NULL); // this is a auto-increment column, so set to default value

    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return     VideoFile Clone of current object.
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
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return     VideoFilePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new VideoFilePeer();
        }
        return self::$peer;
    }

    /**
     * Resets all collections of referencing foreign keys.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect objects
     * with circular references.  This is currently necessary when using Propel in certain
     * daemon or large-volumne/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all associated objects.
     */
    public function clearAllReferences($deep = false)
    {
    }

    /**
     * Calls methods defined via {@link sfMixer}.
     * @throws sfException
     */
    public function __call($method, $arguments)
    {
        if (!$callable = sfMixer::getCallable('BaseVideoFile:' . $method)) {
            throw new sfException(sprintf('Call to undefined method BaseVideoFile::%s', $method));
        }

        array_unshift($arguments, $this);

        return call_user_func_array($callable, $arguments);
    }
}