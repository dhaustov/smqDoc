CREATE TABLE doctemplate (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(256) NOT NULL COMMENT 'имя шаблона',
  PRIMARY KEY (Id)
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Шаблоны документов';