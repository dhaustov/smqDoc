<?php

//Helpers
require_once 'Config.php';
require_once 'Helpers/SqlHelper.php';
require_once 'Helpers/ToolsHelper.php';
require_once 'Helpers/NotificationHelper.php';

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
require_once 'Objects/UserGroupDocTemplates.php';
require_once 'Objects/DocTemplate.php';
require_once 'Objects/DocTemplateField.php';
require_once 'Objects/DocTemplateFieldType.php';
require_once 'Objects/DocTemplateOperation.php';

//Repositories
require_once 'Repositories/UserRepository.php';
require_once 'Repositories/UserGroupRepository.php';
require_once 'Repositories/DocTemplateRepository.php';
require_once 'Repositories/UserGroupDocRepository.php';

//Enums
require_once 'Enums/Enums.php';
require_once 'Enums/Actions.php';
require_once 'Enums/Modules.php';

//commands
require_once 'Commands/UserCommand.php';
require_once 'Commands/UserGroupCommand.php';
require_once 'Commands/DocTemplateCommand.php';

//Validators
require_once 'Validators/UserValidator.php';
require_once 'Validators/UserGroupValidator.php';
require_once 'Validators/DocTemplateValidator.php';

?>
