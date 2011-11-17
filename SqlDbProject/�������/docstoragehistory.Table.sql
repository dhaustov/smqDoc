CREATE TABLE docstoragehistory (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idDocument INT(11) NOT NULL,
  idUser INT(11) NOT NULL,
  NewStatus INT(11) NOT NULL,
  PRIMARY KEY (id),
  INDEX idDocument (idDocument),
  INDEX idUser (idUser),
  CONSTRAINT docstoragehistory_ibfk_1 FOREIGN KEY (idDocument)
    REFERENCES docstorage(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstoragehistory_ibfk_2 FOREIGN KEY (idUser)
    REFERENCES useraccounts(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'История изменения статусов документов';