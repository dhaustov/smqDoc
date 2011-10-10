--
-- Описание для таблицы doctemplate_fields
--
CREATE TABLE doctemplate_fields (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(20) NOT NULL,
  IsCalculated TINYINT(1) NOT NULL,
  IdFieldType INT(11) NOT NULL,
  IsRestricted TINYINT(1) NOT NULL,
  MinVal INT(11) DEFAULT NULL,
  MaxVal INT(11) DEFAULT NULL,
  IdOperation INT(11) NOT NULL,
  IdDoctemplate INT(11) NOT NULL,
  PRIMARY KEY (Id),
  INDEX IdDoctemplate (IdDoctemplate),
  INDEX IdFieldType (IdFieldType),
  INDEX IdOperation (IdOperation),
  CONSTRAINT doctemplate_fields_ibfk_1 FOREIGN KEY (IdFieldType)
    REFERENCES doctemplate_fieldtypes(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT doctemplate_fields_ibfk_2 FOREIGN KEY (IdOperation)
    REFERENCES doctemplate_operations(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_doctemplate_fields_doctemplates_id FOREIGN KEY (IdDoctemplate)
    REFERENCES doctemplates(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;