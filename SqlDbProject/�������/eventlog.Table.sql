﻿--
-- Описание для таблицы eventlog
--
CREATE TABLE eventlog(
  id INT(11) NOT NULL AUTO_INCREMENT,
  EventCode VARCHAR(1024) DEFAULT NULL,
  EventTime DATETIME NOT NULL,
  EventType INT(1) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 15
AVG_ROW_LENGTH = 1170
CHARACTER SET utf8
COLLATE utf8_general_ci;