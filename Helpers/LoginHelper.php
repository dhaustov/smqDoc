<?php

/**
 * Description of LoginHelper
 *
 * @author Павел
 */
class LoginHelper {
    const SES_U_L='sessionUserLogin';
    const SES_UG_L='sessionUserGroup';
    /**
    * @return UserAccount
    */
    public static function GetCurrentUserId()
    {
        if(isset($_SESSION[LoginHelper::SES_U_L]))
        {
            return $_SESSION[LoginHelper::SES_U_L];
        }
        else
        {
            return false;
        }
    }
    public static function GetCurrentUserName()
    {
        $cuId = LoginHelper::GetCurrentUserId();
        if($cuId)
        {
	    $userRep = new UserRepository();
            $tmpUser = $userRep->GetById($cuId);
            return $tmpUser->name;
        }
        else
        {
            return false;
        }
    }
       public static function GetCurrentUser()
    {
        $cuId = LoginHelper::GetCurrentUserId();
        if($cuId)
        {
	    $userRep = new UserRepository();
            $tmpUser = $userRep->GetById($cuId);
            return $tmpUser;
        }
        else
        {
            return false;
        }
    }
    private static function SetCurrentUserId($_userId)
    {
         $_SESSION[LoginHelper::SES_U_L] = $_userId;
    }
    /**
    * @return UserAccount
    */
    public static function Login($_userLogin,$_pass)
    {
        $userRep = new UserRepository();
        $tmpUser = $userRep->GetByLogin($_userLogin);
        if($tmpUser && $tmpUser->password == $_pass)
        {
            $tmpUser->isGuest = false;
            LoginHelper::SetCurrentUserId($tmpUser->id);
            return $tmpUser;
        }
        else
        {
            return false;
        }
    }
    public static function GetCurrentUserGroup()
    {
        $ugRep = new UserGroupRepository();
        if(LoginHelper::GetCurrentUserGroupId())
            return $ugRep->GetById(LoginHelper::GetCurrentUserGroupId());
        return false;
    }
    /**
    * @return UserAccount
    */
    private static function GetGuestUser()
    {
        $tmpUser = new UserAccount();
        $tmpUser->login = "guest"+  rand(0, 9999);
        return $tmpUser;
    }
    public static function LogOut()
    {
         unset($_SESSION[LoginHelper::SES_U_L]);
         session_destroy();
    }
    /**
    * @return Bool
    */
    public static function LoginAsGuest()
    {
        $tmpUser = LoginHelper::GetGuestUser();
        LoginHelper::SetCurrentUser($tmpUser);
        $tmp2User = LoginHelper::GetCurrentUser();
        return (($tmp2User->isGuest == $tmpUser->isGuest ) && ($tmp2User->login == $tmpUser->login ));
    }
    
    public static function GetCurrentUserGroupId()
    {                
        if(isset($_SESSION[LoginHelper::SES_UG_L]))
        {            
            return $_SESSION[LoginHelper::SES_UG_L];
        }
        else
        {            
            return false;
        }
    }
    public static function SetCurrentUserGroupId($_userGroupId)
    {
         $_SESSION[LoginHelper::SES_UG_L] = $_userGroupId;
    }
}

?>
