-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 5.0.50.1
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 10.10.2011 19:35:43
-- Версия сервера: 5.5.16-log
-- Версия клиента: 4.1

USE smqdoc;

CREATE TABLE doctemplate_fieldtypes(
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(20) NOT NULL,
  DataBaseType VARCHAR(20) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE doctemplate_operations(
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(256) NOT NULL,
  Code VARCHAR(64) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Операции для вычислимых полей';

CREATE TABLE doctemplates(
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(256) NOT NULL COMMENT 'имя шаблона',
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Шаблоны документов';

CREATE TABLE eventlog(
  id INT(11) NOT NULL AUTO_INCREMENT,
  EventCode VARCHAR(1024) DEFAULT NULL,
  EventTime DATETIME NOT NULL,
  EventType INT(1) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 14
AVG_ROW_LENGTH = 1260
CHARACTER SET utf8
COLLATE utf8_general_ci;

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
AUTO_INCREMENT = 33
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE doctemplate_fields(
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
  REFERENCES doctemplate_fieldtypes (Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT doctemplate_fields_ibfk_2 FOREIGN KEY (IdOperation)
  REFERENCES doctemplate_operations (Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_doctemplate_fields_doctemplates_id FOREIGN KEY (IdDoctemplate)
  REFERENCES doctemplates (Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE user_groups(
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
  REFERENCES user_accounts (Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 34
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE docstorage(
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
  REFERENCES user_accounts (Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_ibfk_2 FOREIGN KEY (idGroupDocs)
  REFERENCES user_groups (Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE groups_docs(
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
  REFERENCES user_groups (Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 33
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица назначений документов';

CREATE TABLE docstorage_fields(
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
  REFERENCES docstorage (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_fields_ibfk_2 FOREIGN KEY (idDocTemplateField)
  REFERENCES doctemplate_fields (Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица значений полей документов';

CREATE TABLE docstorage_history(
  id INT(11) NOT NULL AUTO_INCREMENT,
  idDocument INT(11) NOT NULL,
  idUser INT(11) NOT NULL,
  NewStatus INT(11) NOT NULL,
  PRIMARY KEY (id),
  INDEX idDocument (idDocument),
  INDEX idUser (idUser),
  CONSTRAINT docstorage_history_ibfk_1 FOREIGN KEY (idDocument)
  REFERENCES docstorage (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_history_ibfk_2 FOREIGN KEY (idUser)
  REFERENCES user_accounts (Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'История изменения статусов документов';

DELIMITER $$

CREATE DEFINER = 'root'@'localhost'
PROCEDURE deleteAll()
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

DELIMITER ;