DELIMITER $$

CREATE PROCEDURE deleteAll()
BEGIN
  DELETE
FROM
  groups_docs;

  DELETE
FROM
  user_groups;

  DELETE
FROM
  user_accounts;
END
$$