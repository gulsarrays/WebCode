<?php

/*
  Project                     : Oriole
  Module                      : DBManager
  File name                   : COREDbManager.php
  Description                 : Database class for connection.
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREDbManager
{

    /* @var $stmt PDOStatement */
    private $stmt;
    private $host   = DB_HOST;
    private $user   = DB_USER_NAME;
    private $pass   = DB_PASSWORD;
    private $dbname = DB_NAME;
    private $dbh;
    private $error;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8mb4;';
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instance
        try
        {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
            // Catch any errors
        catch(PDOException $e)
        {
            $GenMethods             = new COREGeneralMethods();
            $aResult[JSON_TAG_TYPE] = JSON_TAG_ERROR;
            $aResult[JSON_TAG_CODE] = ERROR_CODE_SERVER_COMMUNICATION_FAILED;
            $aResult[JSON_TAG_DESC] = "Internal Server Error -  Unable to connect to DB";
            $GenMethods->generateResult($aResult);
            exit();
        }
    }
    /**
     * Function used to return the pdo object.
     *
     * @return PDO Connection Object
     */
    public function getconnection()
    {
        return $this->dbh;
    }
    public function getPreparedStatement($query)
    {
        if($this->isPDO())
        {
            $this->stmt = $this->dbh->prepare($query);
        }
    }

    public function bind_param($param, $value, $type = null)
    {
        if(is_null($type))
        {
            switch(true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        if($this->isPDO())
        {
            $this->stmt->bindValue($param, $value, $type);
        }
    }

    public function execute()
    {
        if($this->isPDO())
        {
            return $this->stmt->execute();
        }
    }

    public function resultset()
    {
        $this->execute();
        if($this->isPDO())
        {
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function single()
    {
        $this->execute();
        if($this->isPDO())
        {
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function rowCount()
    {
        if($this->isPDO())
        {
            return $this->stmt->rowCount();
        }
    }

    public function lastInsertId()
    {
        if($this->isPDO())
        {
            return $this->dbh->lastInsertId();
        }
    }

    public function beginTransaction()
    {
        if($this->isPDO())
        {
            return $this->dbh->beginTransaction();
        }
    }

    public function endTransaction()
    {
        if($this->isPDO())
        {
            return $this->dbh->commit();
        }
    }

    public function commit()
    {
        if($this->isPDO())
        {
            return $this->dbh->commit();
        }
    }

    public function cancelTransaction()
    {
        if($this->isPDO())
        {
            return $this->dbh->rollBack();
        }
    }

    public function rollback()
    {
        {
            return $this->dbh->rollBack();
        }
    }

    public function debugDumpParams()
    {
        if($this->isPDO())
        {
            return $this->stmt->debugDumpParams();
        }
    }

    //insert Method Declaration
    public function insert($table, $info)
    {
    }

    public function isPDO()
    {
        return $this->dbh instanceof PDO;
    }
}
