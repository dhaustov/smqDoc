CREATE TABLE docstoragefields (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idDocumentStorage INT(11) NOT NULL,
  idDocTemplateField INT(11) NOT NULL,
  StringValue VARCHAR(512) DEFAULT NULL,
  IntValue INT(11) DEFAULT NULL,
  BoolValue TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idDocTemplateField (idDocTemplateField),
  INDEX idDocumentStorage (idDocumentStorage),
  CONSTRAINT docstoragefields_ibfk_1 FOREIGN KEY (idDocumentStorage)
    REFERENCES docstorage(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT docstoragefields_ibfk_2 FOREIGN KEY (idDocTemplateField)
    REFERENCES doctemplatefields(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Таблица значений полей документов';