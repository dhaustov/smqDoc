--
-- Описание для таблицы doctemplates
--
CREATE TABLE doctemplates(
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(256) NOT NULL COMMENT 'имя шаблона',
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Шаблоны документов';