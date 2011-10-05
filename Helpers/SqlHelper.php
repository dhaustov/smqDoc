<?php
//require_once 'Helpers/NotificationHelper.php';

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
            return $mysqli;
    }
    
    public static function ExecInsertQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        $sqlCon->query($query);
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical($sqlCon->real_escape_string("Error executing query: ".$query." Error: ".$sqlCon->error));
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
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical($sqlCon->real_escape_string("Error executing query: ".$query." Error: ".$sqlCon->error));
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                $retVal = $sqlCon->affected_rows;
            }
            
        $sqlCon->close();
        return $retVal;
    }
    public static function ExecDeleteQuery($query)
    {
        ExecUpdateQuery($query);
    }
    public static function ExecSelectValueQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        /* @var $result mysqli_result */
        $result = $sqlCon->query($query);
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical($sqlCon->real_escape_string("Error executing query: ".$query." Error: ".$sqlCon->error));
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                $resRow = $result->fetch_row();
                if(isset($resRow[0]))
                    $retVal = $resRow[0];                               
            }  
        $sqlCon->close();
        return $retVal;
    }
    
    public static function ExecSelectRowQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        /* @var $result mysqli_result */
        $result = $sqlCon->query($query);
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical($sqlCon->real_escape_string("Error executing query: ".$query." Error: ".$sqlCon->error));
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {
                //$resRow = $result->fetch_all(MYSQLI_ASSOC);
//                if($result->num_rows)
//                    $retVal = $resRow[0];                              
                $row = array();
                //while($f = $result->fetch_assoc())
                //    $row[] = $f;
                while ($row = $result->fetch_assoc())
                    $retVal = $row;
                
                echo "retval login - ".$retval['login'].$retval['id'];
            }
            
        $sqlCon->close();
        return $retVal;
        }
               
    public static function ExecSelectCollectionQuery($query)
    {
        $retVal=false;
        $sqlCon = self::InitConnection();
        /* @var $result mysqli_result */
        $result = $sqlCon->query($query);
        if($sqlCon->errno>0)
            {
                NotificationHelper::LogCritical($sqlCon->real_escape_string("Error executing query: ".$query." Error: ".$sqlCon->error));
                ToolsHelper::RedirectToErrorPage();
            }
            else
            {

                    $retVal = $result->fetch_all(MYSQLI_ASSOC);
            }
        $sqlCon->close();
        return $retVal;
    }
    
    
}

?>
