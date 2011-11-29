DELIMITER $$

CREATE PROCEDURE deleteAll()
BEGIN


  DELETE
FROM
  usergroups;

  DELETE
FROM
  useraccounts;
END
$$