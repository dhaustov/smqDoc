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