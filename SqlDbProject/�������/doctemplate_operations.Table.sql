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