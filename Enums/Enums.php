<?php

/**
 * Description of EnLogEventStatus
 *
 * @author Павел
 * Тип события записываемого в базу данных
 */
class EnLogEventType {
    const INFORMATION = 0;
    const WARNING = 1;
    const CRITICAL = 2;
    
}

/**
 * User account statuses
 *
 * @author Dmitry G. Haustov
 */
class UserStatus 
{
    const DELETED = 0;
    const ACTIVE = 1;
    const ADMIN = 2;
}
?>
