--
-- Описание для таблицы doctemplate_operations
--
CREATE TABLE doctemplate_operations(
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(256) NOT NULL,
  code VARCHAR(64) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Операции для вычислимых полей';