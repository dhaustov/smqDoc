--
-- Описание для таблицы user_groups
--
CREATE TABLE user_groups (
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
    REFERENCES user_accounts(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;