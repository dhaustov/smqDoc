﻿--
-- Описание для таблицы docstorage
--
CREATE TABLE docstorage (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idAuthor INT(11) NOT NULL,
  idGroup INT(11) NOT NULL,
  idGroupDocs INT(11) NOT NULL,
  status INT(11) NOT NULL,
  DateCreated DATETIME NOT NULL,
  LastChangedDate DATETIME DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idAuthor (idAuthor),
  INDEX idGroupDocs (idGroupDocs),
  CONSTRAINT docstorage_ibfk_1 FOREIGN KEY (idAuthor)
    REFERENCES useraccounts(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_ibfk_2 FOREIGN KEY (idGroupDocs)
    REFERENCES usergroups(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;