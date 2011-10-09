--
-- Описание для таблицы docstorage
--
CREATE TABLE docstorage (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  IdAuthor INT(11) NOT NULL,
  IdGroup INT(11) NOT NULL,
  IdGroupDocs INT(11) NOT NULL,
  Status INT(11) NOT NULL,
  DateCreated DATETIME NOT NULL,
  LastChangedDate DATETIME DEFAULT NULL,
  PRIMARY KEY (Id),
  INDEX idAuthor (IdAuthor),
  INDEX idGroupDocs (IdGroupDocs),
  CONSTRAINT docstorage_ibfk_1 FOREIGN KEY (IdAuthor)
    REFERENCES user_accounts(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_ibfk_2 FOREIGN KEY (IdGroupDocs)
    REFERENCES user_groups(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;