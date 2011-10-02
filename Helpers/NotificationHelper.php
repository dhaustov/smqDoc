<?php
require_once 'Config.php';
require_once 'SqlHelper.php';
require_once 'ToolsHelper.php';
/*
 * Notification and log class
 */
class NotificationHelper {
    private static function SaveToLocalOSLog($message)
    {
        error_log(date("D, d M Y H:i:s")."=> ".$message);
    }
    public static function SendMail($mail_to,$subject,$message,$headers='')
    {
        
    }
    private static function SendErrorMailToAdmin($subject,$message)
    {
        self::SendMailToAdmin(Config::singleton()->EmailAdmin(),$subject,$message);
    }
    private static function SendErrorMailToDeveloper($subject,$message)
    {
        self::SendMailToAdmin(Config::singleton()->EmailDeveloper(),$subject,$message);
    }
    public static function LogWarning($message)
    {
        //add sql log warning code
    }
    public static function LogInformation($message)
    {
        //add sql log information code
    }
    public static function LogCritical($message)
    {
        //add sql log CRITICAL code
        self::SaveToLocalOSLog($message);
        self::SendErrorMailToDeveloper("Critical error in smqDoc", $message);
        self::SendErrorMailToAdmin("Critical error in smqDoc", $message);
    }
    public static function LogCriticalSQL($message)
    {
        self::SaveToLocalOSLog($message);
        self::SendErrorMailToDeveloper("Critical error in smqDoc: SQL server", $message);
        self::SendErrorMailToAdmin("Critical error in smqDoc: SQL server", $message);
    }
}

?>
