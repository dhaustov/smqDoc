--
-- Описание для таблицы docstorage_fields
--
CREATE TABLE docstorage_fields(
  id INT(11) NOT NULL AUTO_INCREMENT,
  idDocumentStorage INT(11) NOT NULL,
  idDocTemplateField INT(11) NOT NULL,
  StringValue VARCHAR(512) DEFAULT NULL,
  IntValue INT(11) DEFAULT NULL,
  BoolValue TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idDocTemplateField (idDocTemplateField),
  INDEX idDocumentStorage (idDocumentStorage),
  CONSTRAINT docstorage_fields_ibfk_1 FOREIGN KEY (idDocumentStorage)
  REFERENCES docstorage (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_fields_ibfk_2 FOREIGN KEY (idDocTemplateField)
  REFERENCES doctemplate_fields (Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица значений полей документов';