--
-- Описание для таблицы docstorage_fields
--
CREATE TABLE docstorage_fields (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  IdDocumentStorage INT(11) NOT NULL,
  IdDocTemplateField INT(11) NOT NULL,
  StringValue VARCHAR(512) DEFAULT NULL,
  IntValue INT(11) DEFAULT NULL,
  BoolValue TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (Id),
  INDEX idDocTemplateField (IdDocTemplateField),
  INDEX idDocumentStorage (IdDocumentStorage),
  CONSTRAINT docstorage_fields_ibfk_1 FOREIGN KEY (IdDocumentStorage)
    REFERENCES docstorage(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstorage_fields_ibfk_2 FOREIGN KEY (IdDocTemplateField)
    REFERENCES doctemplate_fields(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица значений полей документов';