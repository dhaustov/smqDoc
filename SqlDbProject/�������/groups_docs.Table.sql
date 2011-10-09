--
-- Описание для таблицы groups_docs
--
CREATE TABLE groups_docs (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  IdUserGroups INT(11) NOT NULL,
  Name VARCHAR(256) NOT NULL,
  StartDate DATE DEFAULT NULL,
  EndDate DATE DEFAULT NULL,
  PRIMARY KEY (Id),
  INDEX idUserGroups (IdUserGroups),
  CONSTRAINT groups_docs_ibfk_1 FOREIGN KEY (IdUserGroups)
    REFERENCES user_groups(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица назначений документов';