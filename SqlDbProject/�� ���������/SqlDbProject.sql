-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 5.0.50.1
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 30.10.2011 22:34:58
-- Версия сервера: 5.5.8
-- Пожалуйста, сохраните резервную копию Вашей схемы перед запуском этого скрипта 

CREATE DATABASE IF NOT EXISTS smqdoc COLLATE utf8_general_ci;
USE smqdoc;

-- ..\PreDeployment.sql
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;



-- ..\Таблицы\doctemplate_fieldtypes.Table.sql
--
-- Описание для таблицы doctemplate_fieldtypes
--
CREATE TABLE doctemplate_fieldtypes (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(20) NOT NULL,
  DataBaseType VARCHAR(20) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
CHARACTER SET utf8
COLLATE utf8_general_ci;



-- ..\Таблицы\doctemplate_operations.Table.sql
--
-- Описание для таблицы doctemplate_operations
--
CREATE TABLE doctemplate_operations (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(256) NOT NULL,
  Code VARCHAR(64) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Операции для вычислимых полей';



-- ..\Таблицы\doctemplates.Table.sql
--
-- Описание для таблицы doctemplates
--
CREATE TABLE doctemplates (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(256) NOT NULL COMMENT 'имя шаблона',
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 63
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Шаблоны документов';



-- ..\Таблицы\eventlog.Table.sql
--
-- Описание для таблицы eventlog
--
CREATE TABLE eventlog (
  id INT(11) NOT NULL AUTO_INCREMENT,
  EventCode VARCHAR(1024) DEFAULT NULL,
  EventTime DATETIME NOT NULL,
  EventType INT(1) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;



-- ..\Таблицы\user_accounts.Table.sql
--
-- Описание для таблицы user_accounts
--
CREATE TABLE user_accounts(
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Login VARCHAR(20) NOT NULL,
  `Password` VARCHAR(20) NOT NULL,
  Status INT(11) NOT NULL,
  Name VARCHAR(20) DEFAULT NULL,
  Surname VARCHAR(20) DEFAULT NULL,
  Middlename VARCHAR(20) DEFAULT NULL,
  LastAccess DATETIME DEFAULT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;



-- ..\Таблицы\doctemplate_fields.Table.sql
--
-- Описание для таблицы doctemplate_fields
--
CREATE TABLE doctemplate_fields (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(20) NOT NULL,
  IsCalculated TINYINT(1) NOT NULL,
  IdFieldType INT(11) NOT NULL,
  IsRestricted TINYINT(1) NOT NULL,
  MinVal INT(11) DEFAULT NULL,
  MaxVal INT(11) DEFAULT NULL,
  IdOperation INT(11) NOT NULL,
  IdDoctemplate INT(11) NOT NULL,
  PRIMARY KEY (Id),
  INDEX IdDoctemplate (IdDoctemplate),
  INDEX IdFieldType (IdFieldType),
  INDEX IdOperation (IdOperation),
  CONSTRAINT doctemplate_fields_ibfk_1 FOREIGN KEY (IdFieldType)
    REFERENCES doctemplate_fieldtypes(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT doctemplate_fields_ibfk_2 FOREIGN KEY (IdOperation)
    REFERENCES doctemplate_operations(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_doctemplate_fields_doctemplates_id FOREIGN KEY (IdDoctemplate)
    REFERENCES doctemplates(Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;



-- ..\Таблицы\user_groups.Table.sql
--
-- Описание для таблицы user_groups
--
CREATE TABLE user_groups (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  IdParentGroup INT(11) DEFAULT NULL,
  IdMasterUserAccount INT(11) NOT NULL,
  MasterUserAccountRole VARCHAR(50) NOT NULL,
  status TINYINT(4) DEFAULT 1,
  PRIMARY KEY (Id),
  INDEX IdMasterUserAccount (IdMasterUserAccount),
  INDEX IdParentGroup (IdParentGroup),
  CONSTRAINT user_groups_ibfk_2 FOREIGN KEY (IdMasterUserAccount)
    REFERENCES user_accounts(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;



-- ..\Таблицы\docstorage.Table.sql
--
-- Описание для таблицы docstorage
--
CREATE TABLE docstorage (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idAuthor INT(11) NOT NULL,
  idGroup INT(11) NOT NULL,
  idGroupDocs INT(11) NOT NULL,
  status INT(11) NOT NULL,
  DateCreated DATETIME NOT NULL,
  LastChangedDate DATETIME DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idAuthor (idAuthor),
  INDEX idGroupDocs (idGroupDocs),
  CONSTRAINT docstorage_ibfk_1 FOREIGN KEY (idAuthor)
    REFERENCES user_accounts(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_ibfk_2 FOREIGN KEY (idGroupDocs)
    REFERENCES user_groups(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;



-- ..\Таблицы\groups_docs.Table.sql
--
-- Описание для таблицы groups_docs
--
CREATE TABLE groups_docs (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idUserGroups INT(11) NOT NULL,
  Name VARCHAR(256) NOT NULL,
  StartDate DATE DEFAULT NULL,
  EndDate DATE DEFAULT NULL,
  status TINYINT(4) DEFAULT 1 COMMENT 'Статус связи',
  idDocTemplate INT(11) NOT NULL COMMENT 'Шаблон документа, привязываемый к группе',
  PRIMARY KEY (id),
  INDEX idUserGroups (idUserGroups),
  CONSTRAINT groups_docs_ibfk_1 FOREIGN KEY (idUserGroups)
    REFERENCES user_groups(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица назначений документов';



-- ..\Таблицы\docstorage_fields.Table.sql
--
-- Описание для таблицы docstorage_fields
--
CREATE TABLE docstorage_fields (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idDocumentStorage INT(11) NOT NULL,
  idDocTemplateField INT(11) NOT NULL,
  StringValue VARCHAR(512) DEFAULT NULL,
  IntValue INT(11) DEFAULT NULL,
  BoolValue TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idDocTemplateField (idDocTemplateField),
  INDEX idDocumentStorage (idDocumentStorage),
  CONSTRAINT docstorage_fields_ibfk_1 FOREIGN KEY (idDocumentStorage)
    REFERENCES docstorage(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_fields_ibfk_2 FOREIGN KEY (idDocTemplateField)
    REFERENCES doctemplate_fields(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица значений полей документов';



-- ..\Таблицы\docstorage_history.Table.sql
--
-- Описание для таблицы docstorage_history
--
CREATE TABLE docstorage_history (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idDocument INT(11) NOT NULL,
  idUser INT(11) NOT NULL,
  NewStatus INT(11) NOT NULL,
  PRIMARY KEY (id),
  INDEX idDocument (idDocument),
  INDEX idUser (idUser),
  CONSTRAINT docstorage_history_ibfk_1 FOREIGN KEY (idDocument)
    REFERENCES docstorage(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_history_ibfk_2 FOREIGN KEY (idUser)
    REFERENCES user_accounts(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'История изменения статусов документов';



-- ..\PostDeployment.sql
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
INSERT INTO doctemplate_fieldtypes 
  VALUES 
  (1, 'String', 'stringValue'), 
  (2, 'Int', 'intValue'), 
  (3, 'Bool', 'boolValue');
INSERT INTO doctemplate_operations 
  VALUES 
  (1, 'Summ', '{a}+{b}'), 
  (2, 'Mult', '{a}*{b}'), 
  (3, 'Razn', '{a}-{b}');



-- ..\Процедуры\deleteAll.Procedure.sql
DELIMITER $$

CREATE PROCEDURE deleteAll()
BEGIN
  DELETE
FROM
  groups_docs;

  DELETE
FROM
  user_groups;

  DELETE
FROM
  user_accounts;
END
$$

