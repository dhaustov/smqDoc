<?php

class SqlHelper {
    /**
 * @return mysqli
 */
    private static function InitConnection()
    {            
            $conf = Config::singleton();
            $mysqli = new mysqli($conf->DbHostName(),$conf->DbUserName(),
                    $conf->DbPassword(),$conf->DbName());
            
            if($mysqli->connect_errno>0)
            {
                NotificationHelper::LogCriticalSqlConnection("Connection to Sql server Error: ".$mysqli->connect_error);
                ToolsHelper::RedirectToErrorPage();
                return false;
            }
            $mysqli->set_charset("utf8");
            if($mysqli->errno>0)
            {
                NotificationHelper::LogCritical("Error setting charset Error: ".$sqlCon->error);
                ToolsHelper::RedirectToErrorPage();
                return false;
            }
            return $mysqli;
    }
    public static function StartTransaction()
    {
        $mysqli = SqlHelper::InitConnection();
        $mysqli->autocommit(false);
        return $mysqli;
    }
    public static function CommitTransaction($mysqli)
    {
        /*@var $mysqli mysqli */
        $mysqli->commit();
        $mysqli->close();
    }
    public static function RollbackTransaction($mysqli)
    {
        /*@var $mysqli mysqli */
        $mysqli->rollback();
        $mysqli->close();
    }
    public static function Real_escape_string($str)
    {
        $sqlCon = self::InitConnection();
        return $sqlCon->real_escape_string($str);
    }


    public static function ExecInsertQuery($query,$sqlCon=null)
    {
        $retVal=false;
        $isNeedClose=false;
        if(is_null($sqlCon))
        {
            $isNeedClose = true;
            $sqlCon = self::InitConnection();
        }
        $sqlCon->query($query);
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".$sqlCon->error);
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                $retVal = $sqlCon->insert_id;
            }
            
        if($isNeedClose) $sqlCon->close();
        return $retVal;
    }
    public static function ExecUpdateQuery($query,$sqlCon=null)
    {
        $retVal=false;
        $isNeedClose=false;
        if(is_null($sqlCon))
        {
            $isNeedClose = true;
            $sqlCon = self::InitConnection();
        }
        $sqlCon->query($query);
        if($sqlCon->errno > 0)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".$sqlCon->error);
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                $retVal = $sqlCon->affected_rows;
                //echo "retval updated rows:".$retVal." for query $query<br />";
                
            }
            
        if($isNeedClose) $sqlCon->close();
        return $retVal;
    }
    public static function ExecDeleteQuery($query,$sqlCon=null)
    {
        $res =  self::ExecUpdateQuery($query,$sqlCon);        
        return $res;
    }
    public static function ExecSelectValueQuery($query,$sqlCon=null)
    {
        $retVal=false;
        $isNeedClose=false;
        if(is_null($sqlCon))
        {
            $isNeedClose = true;
            $sqlCon = self::InitConnection();
        }
        /* @var $result mysqli_result */
        $result = $sqlCon->query($query);
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".$sqlCon->error);
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                $resRow = $result->fetch_row();
                if(isset($resRow[0]))
                    $retVal = $resRow[0];                               
            }  
        if($isNeedClose) $sqlCon->close();
        return $retVal;
    }
    public static function ExecSelectRowQuery($query,$sqlCon=null)
    {
        $retVal=false;
        $isNeedClose=false;
        if(is_null($sqlCon))
        {
            $isNeedClose = true;
            $sqlCon = self::InitConnection();
        }
        /* @var $result mysqli_result */
        $result = $sqlCon->query($query);
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".$sqlCon->error);
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                $resRow = $result->fetch_assoc();                
                    $retVal = $resRow;   
                    //echo "count resRow: ".count($resRow)."<br />";
            }
            
        if($isNeedClose) $sqlCon->close();
        return $retVal;
        }       
    public static function ExecSelectCollectionQuery($query,$sqlCon=null)
    {
        $retVal=false;
        $isNeedClose=false;
        if(is_null($sqlCon))
        {
            $isNeedClose = true;
            $sqlCon = self::InitConnection();
        }
        /* @var $result mysqli_result */
        $result = $sqlCon->query($query);
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".$sqlCon->error);
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                //$retVal = $result->fetch_all(MYSQLI_ASSOC);
                    $i=0;
                    while($row = $result->fetch_assoc())
                    {
                        $retVal[$i] = $row;
                        $i++;
                    }
            }
        if($isNeedClose) $sqlCon->close();
        return $retVal;
    }
    
    
}

?>
