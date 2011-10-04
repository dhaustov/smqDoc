--
-- Описание для таблицы doctemplate_fieldtypes
--
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