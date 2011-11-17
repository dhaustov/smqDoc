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