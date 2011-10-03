<?php
require_once 'Helpers/NotificationHelper.php';

class SqlHelper {
    /**
 * @return mysqli
 */
    private static function InitConnection()
    {
            $conf = Config::singleton();
            $mysqli = new mysqli($conf->DbHostName(),$conf->DbUserName(),
                    $conf->DbPassword(),$conf->DbName());
            if(mysqli_connect_errno())
            {
                NotificationHelper::LogCriticalSqlConnection("Connection to Sql server Error: ".mysqli_error());
                ToolsHelper::RedirectToErrorPage();
                return false;
            }
            return $mysqli;
    }
    
    public static function ExecInsertQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        $sqlCon->query($query);
        if($sqlCon->errno)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".mysqli_error());
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                $retVal = $sqlCon->insert_id;
            }
            
        $sqlCon->close();
        return $retVal;
    }
    public static function ExecUpdateQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        $sqlCon->query($query);
        if($sqlCon->errno)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".mysqli_error());
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                $retVal = $sqlCon->affected_rows;
            }
            
        $sqlCon->close();
        return $retVal;
    }
    public static function ExecSelectValueQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        $result = $sqlCon->query($query);
        if($sqlCon->errno)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".mysqli_error());
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                if(isset($result[0]))
                    $retVal = $result[0];                               
            }
            
        $sqlCon->close();
        return $retVal;
    }
    
    public static function ExecSelectRowQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        $result = $sqlCon->query($query);
        if($sqlCon->errno)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".mysqli_error());
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                if(isset($result[0]) && count($result[0]) > 1 )
                    $retVal = $result[0];                               
            }
            
        $sqlCon->close();
        return $retVal;
        }
               
    public static function ExecSelectCollectionQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        $result = $sqlCon->query($query);
        if($sqlCon->errno)
            {
                NotificationHelper::LogCritical("Error executing query: ".$query." Error: ".mysqli_error());
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                if(count($result) > 0 )
                {
                    //$result->
                    $i=0;
                    foreach($result as $value)
                    {
                        $retVal[$i] = $value;
                        $i++;
                    }
                }
                        
            }
            
        $sqlCon->close();
        return $retVal;
    }
    
    
}

?>
