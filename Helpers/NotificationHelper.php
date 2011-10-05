<?php
//require_once 'Config.php';
//require_once 'Helpers/SqlHelper.php';
//require_once 'Helpers/ToolsHelper.php';
/*
 * Notification and log class
 */
class NotificationHelper {
    private static function SaveToLocalOSLog($message)
    {
        error_log(date("d.m.Y h:i:s")."=> ".$message."\n",3,  Config::singleton()->ErrorLogFile());
    }
    
    private static function server_parse($socket, $response, $line = __LINE__) 
    {
        if(!isset($server_response))
            $server_response = "";
        while (substr($server_response, 3, 1) != ' ') 
                {
                if (!($server_response = fgets($socket, 256))) 
                    {
                    return false;
                    }
                }
        if (!(substr($server_response, 0, 3) == $response)) 
                {
                    return false;
                }
    return true;
    }

    public static function SendMail($mail_to,$subject,$message,$headers='')
    {
        $conf = Config::singleton();
        $SEND =   "Date: ".date("D, d M Y H:i:s") . " UT\r\n";
        $SEND .=   'Subject: =?'.$conf->SmtpCharset().'?B?'.base64_encode($subject)."=?=\r\n";
        if ($headers) $SEND .= $headers."\r\n\r\n";
        else
        {
                $SEND .= "Reply-To: ".$conf->SmtpUserName()."\r\n";
                $SEND .= "MIME-Version: 1.0\r\n";
                $SEND .= "Content-Type: text/plain; charset=\"".$conf->SmtpCharset()."\"\r\n";
                $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
                $SEND .= "From: \"".$conf->SmtpFrom()."\" <".$conf->SmtpUserName().">\r\n";
                $SEND .= "To: $mail_to <$mail_to>\r\n";
                $SEND .= "X-Priority: 3\r\n\r\n";
        }
        $SEND .=  $message."\r\n";
         if( !$socket = fsockopen($conf->SmtpHost(), $conf->SmtpPort(), $errno, $errstr, 30) ) {
            return false;
         }

            if (!self::server_parse($socket, "220", __LINE__)) return false;

            fputs($socket, "HELO " . $conf->SmtpHost() . "\r\n");
            if (!self::server_parse($socket, "250", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "AUTH LOGIN\r\n");
            if (!self::server_parse($socket, "334", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, base64_encode($conf->SmtpUserName()) . "\r\n");
            if (!self::server_parse($socket, "334", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, base64_encode($conf->SmtpPassword()) . "\r\n");
            if (!self::server_parse($socket, "235", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "MAIL FROM: <".$conf->SmtpUserName().">\r\n");
            if (!self::server_parse($socket, "250", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");

            if (!self::server_parse($socket, "250", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "DATA\r\n");

            if (!self::server_parse($socket, "354", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, $SEND."\r\n.\r\n");

            if (!self::server_parse($socket, "250", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "QUIT\r\n");
            fclose($socket);
            return TRUE;
    }
    public static function SendErrorMailToAdmin($subject,$message)
    {
        return self::SendMail(Config::singleton()->EmailAdmin(),$subject,$message);
    }
    public static function SendErrorMailToDeveloper($subject,$message)
    {
        return self::SendMail(Config::singleton()->EmailDeveloper(),$subject,$message);
    }
    public static function LogWarning($message)
    {
        if(Config::singleton()->ErrorLogLevel() <= EnLogEventType::WARNING)
            SqlHelper::ExecInsertQuery("INSERT INTO eventlog ( EventCode, EventTime, EventType) VALUES ('$message', NOW(),'".EnLogEventType::WARNING."' )");
    }
    public static function LogInformation($message)
    {
        if(Config::singleton()->ErrorLogLevel() <= EnLogEventType::INFORMATION)
        SqlHelper::ExecInsertQuery("INSERT INTO eventlog ( EventCode, EventTime, EventType) VALUES ('$message', NOW(),'".EnLogEventType::INFORMATION."' )");
    }
    public static function LogCritical($message)
    {
        SqlHelper::ExecInsertQuery("INSERT INTO eventlog ( EventCode, EventTime, EventType) VALUES ('$message', NOW(),'".EnLogEventType::CRITICAL."' )");
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
