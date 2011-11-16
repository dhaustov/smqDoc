CREATE TABLE usergroups_doctemplates (
  id INT(11) NOT NULL AUTO_INCREMENT,
  idGroup INT(11) NOT NULL COMMENT 'id группы пользователей',
  idDoctemplate INT(11) NOT NULL COMMENT 'id шаблона документа',
  PRIMARY KEY (id),
  INDEX FK_usergroups_doctemplates_doctemplates_Id (idDoctemplate),
  INDEX FK_usergroups_doctemplates_user_groups_Id (idGroup),
  CONSTRAINT FK_usergroups_doctemplates_doctemplates_Id FOREIGN KEY (idDoctemplate)
    REFERENCES doctemplate(Id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_usergroups_doctemplates_user_groups_Id FOREIGN KEY (idGroup)
    REFERENCES user_groups(Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;