-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 02 2011 г., 14:46
-- Версия сервера: 5.1.53
-- Версия PHP: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `smqdoc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `docstorage`
--

CREATE TABLE IF NOT EXISTS `docstorage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idAuthor` int(11) NOT NULL,
  `idGroup` int(11) NOT NULL,
  `idGroupDocs` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `LastChangedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idAuthor` (`idAuthor`),
  KEY `idGroupDocs` (`idGroupDocs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `docstorage_fields`
--

CREATE TABLE IF NOT EXISTS `docstorage_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idDocumentStorage` int(11) NOT NULL,
  `idDocTemplateField` int(11) NOT NULL,
  `StringValue` varchar(512) DEFAULT NULL,
  `IntValue` int(11) DEFAULT NULL,
  `BoolValue` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idDocumentStorage` (`idDocumentStorage`),
  KEY `idDocTemplateField` (`idDocTemplateField`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица значений полей документов' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `docstorage_history`
--

CREATE TABLE IF NOT EXISTS `docstorage_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idDocument` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `NewStatus` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idDocument` (`idDocument`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='История изменения статусов документов' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `doctemplates`
--

CREATE TABLE IF NOT EXISTS `doctemplates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL COMMENT 'имя шаблона',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Шаблоны документов' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `doctemplate_fields`
--

CREATE TABLE IF NOT EXISTS `doctemplate_fields` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `IsCalculated` tinyint(1) NOT NULL,
  `IdFieldType` int(11) NOT NULL,
  `IsRestricted` tinyint(1) NOT NULL,
  `MinVal` int(11) DEFAULT NULL,
  `MaxVal` int(11) DEFAULT NULL,
  `IdOperation` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdFieldType` (`IdFieldType`),
  KEY `IdOperation` (`IdOperation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `doctemplate_fieldtypes`
--

CREATE TABLE IF NOT EXISTS `doctemplate_fieldtypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `DataBaseType` varchar(20) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `doctemplate_operations`
--

CREATE TABLE IF NOT EXISTS `doctemplate_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `code` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Операции для вычислимых полей' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `groups_docs`
--

CREATE TABLE IF NOT EXISTS `groups_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUserGroups` int(11) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idUserGroups` (`idUserGroups`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица назначений документов' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Login` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Status` int(11) NOT NULL,
  `Name` varchar(20) DEFAULT NULL,
  `Surname` varchar(20) DEFAULT NULL,
  `Middlename` varchar(20) DEFAULT NULL,
  `LastAccess` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `IdParentGroup` int(11) DEFAULT NULL,
  `IdMasterUserAccount` int(11) NOT NULL,
  `MasterUserAccountRole` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdParentGroup` (`IdParentGroup`),
  KEY `IdMasterUserAccount` (`IdMasterUserAccount`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `docstorage`
--
ALTER TABLE `docstorage`
  ADD CONSTRAINT `docstorage_ibfk_2` FOREIGN KEY (`idGroupDocs`) REFERENCES `user_groups` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `docstorage_ibfk_1` FOREIGN KEY (`idAuthor`) REFERENCES `user_accounts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `docstorage_fields`
--
ALTER TABLE `docstorage_fields`
  ADD CONSTRAINT `docstorage_fields_ibfk_2` FOREIGN KEY (`idDocTemplateField`) REFERENCES `doctemplate_fields` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `docstorage_fields_ibfk_1` FOREIGN KEY (`idDocumentStorage`) REFERENCES `docstorage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `docstorage_history`
--
ALTER TABLE `docstorage_history`
  ADD CONSTRAINT `docstorage_history_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user_accounts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `docstorage_history_ibfk_1` FOREIGN KEY (`idDocument`) REFERENCES `docstorage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `doctemplate_fields`
--
ALTER TABLE `doctemplate_fields`
  ADD CONSTRAINT `doctemplate_fields_ibfk_2` FOREIGN KEY (`IdOperation`) REFERENCES `doctemplate_operations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `doctemplate_fields_ibfk_1` FOREIGN KEY (`IdFieldType`) REFERENCES `doctemplate_fieldtypes` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `groups_docs`
--
ALTER TABLE `groups_docs`
  ADD CONSTRAINT `groups_docs_ibfk_1` FOREIGN KEY (`idUserGroups`) REFERENCES `user_groups` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `user_groups_ibfk_1` FOREIGN KEY (`IdParentGroup`) REFERENCES `user_groups` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_groups_ibfk_2` FOREIGN KEY (`IdMasterUserAccount`) REFERENCES `user_accounts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
