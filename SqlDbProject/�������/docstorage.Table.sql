--
-- Описание для таблицы docstorage
--
CREATE TABLE docstorage (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idAuthor INT(11) NOT NULL,
  idGroup INT(11) NOT NULL,
  idUserGroup_DocTemplates INT(11) NOT NULL,
  status INT(11) NOT NULL,
  DateCreated DATETIME NOT NULL,
  LastChangedDate DATETIME DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idAuthor (idAuthor),
  INDEX idGroupDocs (idUserGroup_DocTemplates),
  CONSTRAINT docstorage_ibfk_1 FOREIGN KEY (idAuthor)
    REFERENCES useraccounts(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_usergroups_doctemplates FOREIGN KEY (idUserGroup_DocTemplates)
    REFERENCES usergroups_doctemplates(id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;