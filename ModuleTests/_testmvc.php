<?php
require_once "/Models/UserModel.php";
require_once '/Views/UserView.php';
require_once '/Views/MainLayoutView.php';
require_once '/Controllers/UserController.php';

require_once "/Models/UserGroupModel.php";
require_once '/Views/UserGroupView.php';
require_once '/Controllers/UserGroupController.php';

require_once "/Models/DocTemplateModel.php";
require_once '/Views/DocTemplateView.php';
require_once '/Controllers/DocTemplateController.php';


switch($_REQUEST['module'])
{
    case Modules::USERS :
        $uc = new UserController($_REQUEST);
        $uc->RunModel();
        $uc->ShowResult();
        break;
    case Modules::USERGROUPS :
        $ugc = new UserGroupController($_REQUEST);
        $ugc->RunModel();
        $ugc->ShowResult();
        break;
    case Modules::DOCTEMPLATES :
        $dtc = new DocTemplateController($_REQUEST);
        $dtc->RunModel();
        $dtc->ShowResult();
        break;
    default:
        ToolsHelper::RedirectToErrorPage("Wrong module!");
        break;
}
        
?>
