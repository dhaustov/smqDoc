<?php
session_start();
//Helpers
require_once 'Config.php';
require_once 'Helpers/SqlHelper.php';
require_once 'Helpers/ToolsHelper.php';
require_once 'Helpers/NotificationHelper.php';
require_once 'Helpers/LoginHelper.php';

//Interfaces
require_once 'Interfaces/IObjectRepository.php';
require_once 'Interfaces/IValidator.php';
require_once 'Interfaces/IModel.php';
require_once 'Interfaces/IView.php';
require_once 'Interfaces/IMasterPageView.php';
require_once 'Interfaces/IController.php';

//Objects
require_once 'Objects/TemplateMenuItem.php';
require_once 'Objects/TemplateHeaderItem.php';
require_once 'Objects/TemplateFooterItem.php';

require_once 'Objects/User.php';
require_once 'Objects/UserGroup.php';
require_once 'Objects/UserGroupDoc.php';
require_once 'Objects/UserGroupDocField.php';
require_once 'Objects/UserGroup_DocTemplates.php';
require_once 'Objects/DocTemplate.php';
require_once 'Objects/DocTemplateField.php';

//Repositories
require_once 'Repositories/UserRepository.php';
require_once 'Repositories/UserGroupRepository.php';
require_once 'Repositories/DocTemplateRepository.php';
require_once 'Repositories/UserGroupDocRepository.php';
require_once 'Repositories/UserGroup_DocTemplatesRepository.php';

//Enums
require_once 'Enums/Enums.php';
require_once 'Enums/Actions.php';
require_once 'Enums/Modules.php';

//commands
require_once 'Commands/UserCommand.php';
require_once 'Commands/UserGroupCommand.php';
require_once 'Commands/UserGroupDocCommand.php';
require_once 'Commands/DocTemplateCommand.php';
require_once 'Commands/DashboardCommand.php';

//Validators
require_once 'Validators/UserValidator.php';
require_once 'Validators/UserGroupValidator.php';
require_once 'Validators/UserGroupDocValidator.php';
require_once 'Validators/DocTemplateValidator.php';

//MVC
require_once '/Views/MainLayoutView.php';

require_once '/Models/UserModel.php';
require_once '/Views/UserView.php';
require_once '/Controllers/UserController.php';

require_once '/Models/UserGroupModel.php';
require_once '/Views/UserGroupView.php';
require_once '/Controllers/UserGroupController.php';

require_once '/Models/DocTemplateModel.php';
require_once '/Views/DocTemplateView.php';
require_once '/Controllers/DocTemplateController.php';

require_once '/Models/DashboardModel.php';
require_once '/Views/DashboardView.php';
require_once '/Controllers/DashboardController.php';

require_once '/Models/UserGroupDocModel.php';
require_once '/Views/UserGroupDocView.php';
require_once '/Controllers/UserGroupDocController.php';
?>
