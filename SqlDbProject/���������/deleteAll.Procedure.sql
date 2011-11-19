DELIMITER $$

CREATE PROCEDURE deleteAll()
BEGIN
  DELETE
FROM
  groups_docs;

  DELETE
FROM
  usergroups;

  DELETE
FROM
  useraccounts;
END
$$