--
-- Описание для таблицы doctemplate_fields
--
CREATE TABLE doctemplate_fields (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(20) NOT NULL,
  IsCalculated TINYINT(1) NOT NULL,
  FieldType INT(11) NOT NULL,
  IsRestricted TINYINT(1) NOT NULL,
  MinVal INT(11) DEFAULT NULL,
  MaxVal INT(11) DEFAULT NULL,
  IdDoctemplate INT(11) NOT NULL,
  PRIMARY KEY (Id),
  INDEX IdDoctemplate (IdDoctemplate),
  INDEX IdFieldType (FieldType),
  CONSTRAINT FK_doctemplate_fields_doctemplates_id FOREIGN KEY (IdDoctemplate)
    REFERENCES doctemplate(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;