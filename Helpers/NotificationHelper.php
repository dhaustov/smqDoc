<?php
require_once 'Config.php';
require_once 'Helpers/SqlHelper.php';
require_once 'Helpers/ToolsHelper.php';
/*
 * Notification and log class
 */
class NotificationHelper {
    private static function SaveToLocalOSLog($message)
    {
        error_log(date("d.m.Y h:i:s")."=> ".$message."\n",3,  Config::singleton()->ErrorLogFile());
    }
    public static function SendMail($mail_to,$subject,$message,$headers='')
    {
        echo "Email sended to ".$mail_to."<br>";
    }
    private static function SendErrorMailToAdmin($subject,$message)
    {
        self::SendMail(Config::singleton()->EmailAdmin(),$subject,$message);
    }
    private static function SendErrorMailToDeveloper($subject,$message)
    {
        self::SendMail(Config::singleton()->EmailDeveloper(),$subject,$message);
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
    public static function LogCriticalSqlConnection($message)
    {
        self::SaveToLocalOSLog($message);
        //self::SendErrorMailToDeveloper("Critical error in smqDoc", $message);
        self::SendErrorMailToAdmin("Critical error in smqDoc", $message);
    }
}

?>
