/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
INSERT INTO doctemplate_fieldtypes 
  VALUES 
  (1, 'String', 'stringValue'), 
  (2, 'Int', 'intValue'), 
  (3, 'Bool', 'boolValue');
INSERT INTO doctemplate_operations 
  VALUES 
  (1, 'Summ', '{a}+{b}'), 
  (2, 'Mult', '{a}*{b}'), 
  (3, 'Razn', '{a}-{b}');