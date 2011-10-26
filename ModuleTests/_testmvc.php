<?php
require_once "/Models/UserModel.php";
require_once '/Views/UserView.php';
require_once '/Views/MainLayoutView.php';
require_once '/Controllers/UserController.php';

switch($_REQUEST['module'])
{
    case Modules::USERS :
        $uc = new UserController($_REQUEST);
        $uc->RunModel();
        $uc->ShowResult();
        break;
    default:
        echo "wrong module";
        break;
}
        
?>
