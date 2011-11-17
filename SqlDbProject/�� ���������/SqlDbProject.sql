﻿-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 5.0.50.1
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 17.11.2011 22:58:42
-- Версия сервера: 5.5.8
-- Пожалуйста, сохраните резервную копию Вашей схемы перед запуском этого скрипта 

CREATE DATABASE IF NOT EXISTS smqdoc COLLATE utf8_general_ci;
USE smqdoc;

-- ..\PreDeployment.sql
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;



-- ..\Таблицы\useraccounts.Table.sql
CREATE TABLE useraccounts (
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
CHARACTER SET utf8
COLLATE utf8_general_ci;



-- ..\Таблицы\usergroups.Table.sql
CREATE TABLE usergroups (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  IdParentGroup INT(11) DEFAULT NULL,
  IdMasterUserAccount INT(11) NOT NULL,
  MasterUserAccountRole VARCHAR(50) NOT NULL,
  status TINYINT(4) DEFAULT 1,
  PRIMARY KEY (Id),
  INDEX IdMasterUserAccount (IdMasterUserAccount),
  INDEX IdParentGroup (IdParentGroup),
  CONSTRAINT usergroups_ibfk_2 FOREIGN KEY (IdMasterUserAccount)
    REFERENCES useraccounts(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;



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



-- ..\Таблицы\doctemplate.Table.sql
CREATE TABLE doctemplate (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(256) NOT NULL COMMENT 'имя шаблона',
  PRIMARY KEY (Id)
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Шаблоны документов';



-- ..\Таблицы\doctemplatefields.Table.sql
CREATE TABLE doctemplatefields (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(20) NOT NULL,
  IsCalculated TINYINT(1) NOT NULL,
  FieldType INT(11) NOT NULL,
  IsRestricted TINYINT(1) NOT NULL,
  MinVal INT(11) DEFAULT NULL,
  MaxVal INT(11) DEFAULT NULL,
  IdDoctemplate INT(11) NOT NULL,
  PRIMARY KEY (Id),
  INDEX IdDoctemplate (IdDoctemplate),
  INDEX IdFieldType (FieldType),
  CONSTRAINT FK_doctemplate_fields_doctemplates_id FOREIGN KEY (IdDoctemplate)
    REFERENCES doctemplate(Id) ON DELETE CASCADE ON UPDATE CASCADE
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
    REFERENCES useraccounts(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_ibfk_2 FOREIGN KEY (idGroupDocs)
    REFERENCES usergroups(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;



-- ..\Таблицы\usergroups_doctemplates.Table.sql
CREATE TABLE usergroups_doctemplates (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idUserGroups INT(11) NOT NULL,
  Name VARCHAR(256) NOT NULL,
  StartDate DATE DEFAULT NULL,
  EndDate DATE DEFAULT NULL,
  status TINYINT(4) DEFAULT 1 COMMENT 'Статус связи',
  idDocTemplate INT(11) NOT NULL COMMENT 'Шаблон документа, привязываемый к группе',
  PRIMARY KEY (id),
  INDEX idUserGroups (idUserGroups),
  CONSTRAINT usergroups_doctemplates_ibfk_1 FOREIGN KEY (idUserGroups)
    REFERENCES usergroups(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица назначений документов';



-- ..\Процедуры\deleteAll.Procedure.sql
DELIMITER $$

CREATE PROCEDURE deleteAll()
BEGIN
  DELETE
FROM
  groups_docs;

  DELETE
FROM
  usergroups;

  DELETE
FROM
  useraccounts;
END
$$



-- ..\PostDeployment.sql




-- ..\Таблицы\docstoragefields.Table.sql
CREATE TABLE docstoragefields (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idDocumentStorage INT(11) NOT NULL,
  idDocTemplateField INT(11) NOT NULL,
  StringValue VARCHAR(512) DEFAULT NULL,
  IntValue INT(11) DEFAULT NULL,
  BoolValue TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idDocTemplateField (idDocTemplateField),
  INDEX idDocumentStorage (idDocumentStorage),
  CONSTRAINT docstoragefields_ibfk_1 FOREIGN KEY (idDocumentStorage)
    REFERENCES docstorage(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstoragefields_ibfk_2 FOREIGN KEY (idDocTemplateField)
    REFERENCES doctemplatefields(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица значений полей документов';



-- ..\Таблицы\docstoragehistory.Table.sql
CREATE TABLE docstoragehistory (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idDocument INT(11) NOT NULL,
  idUser INT(11) NOT NULL,
  NewStatus INT(11) NOT NULL,
  PRIMARY KEY (id),
  INDEX idDocument (idDocument),
  INDEX idUser (idUser),
  CONSTRAINT docstoragehistory_ibfk_1 FOREIGN KEY (idDocument)
    REFERENCES docstorage(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstoragehistory_ibfk_2 FOREIGN KEY (idUser)
    REFERENCES useraccounts(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'История изменения статусов документов';

