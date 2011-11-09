<!--<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>-->
        <?php
               require_once 'Init.php';              
               include_once 'Login.php';
               
               if(LoginHelper::GetCurrentUserId())   
               {
               //include_once 'dt.php';
                if(!isset($_REQUEST['module']))
                  $_REQUEST['module'] = Modules::DASHBOARD;  
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
                    case Modules::DOCUMENTS :
                        $dc = new UserGroupDocController($_REQUEST);
                        $dc->RunModel();
                        $dc->ShowResult();
                    default:
                        $dashc = new DashboardController($_REQUEST);
                        $dashc->RunModel();
                        $dashc->ShowResult();
                        break;
                }
               }
           
        ?>
<!--        <a href="./dt.php" title="Дмитрий">Дмитрий</a><br>
        <a href="./pavelTest.php" title="Павел">Павел</a>
    </body>
</html>-->

