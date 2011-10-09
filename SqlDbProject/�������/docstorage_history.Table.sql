--
-- Описание для таблицы docstorage_history
--
CREATE TABLE docstorage_history (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  IdDocument INT(11) NOT NULL,
  IdUser INT(11) NOT NULL,
  NewStatus INT(11) NOT NULL,
  PRIMARY KEY (Id),
  INDEX idDocument (IdDocument),
  INDEX idUser (IdUser),
  CONSTRAINT docstorage_history_ibfk_1 FOREIGN KEY (IdDocument)
    REFERENCES docstorage(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_history_ibfk_2 FOREIGN KEY (IdUser)
    REFERENCES user_accounts(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'История изменения статусов документов';