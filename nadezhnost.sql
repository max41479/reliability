-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 27 2014 г., 02:35
-- Версия сервера: 5.5.28
-- Версия PHP: 5.5.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `nadezhnost`
--

-- --------------------------------------------------------

--
-- Структура таблицы `element_types`
--

CREATE TABLE IF NOT EXISTS `element_types` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `k` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `element_types`
--

INSERT INTO `element_types` (`id`, `name`, `k`) VALUES
(1, 'Микросхема', 0),
(2, 'Резистор', 0),
(3, 'Дроссель', 0),
(4, 'Диод', 0),
(5, 'Конденсатор', 0),
(6, 'Кварцевый генератор', 0),
(7, 'Вилка', 0),
(8, 'Клемма приборная', 0),
(9, 'Тумблер', 0),
(10, 'Печатная плата', 0),
(11, 'Пайка', 0),
(12, 'Трансформатор', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `k_r_diod_coefficients`
--

CREATE TABLE IF NOT EXISTS `k_r_diod_coefficients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `a` float NOT NULL,
  `n_t` float NOT NULL,
  `t_m` float NOT NULL,
  `l` float NOT NULL,
  `delta_t` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `k_r_diod_coefficients`
--

INSERT INTO `k_r_diod_coefficients` (`id`, `name`, `a`, `n_t`, `t_m`, `l`, `delta_t`) VALUES
(1, 'Диоды, кроме стабилитронов, диодные сборки', 44.1025, -2138, 448, 17.7, 150);

-- --------------------------------------------------------

--
-- Структура таблицы `k_r_is_coefficients`
--

CREATE TABLE IF NOT EXISTS `k_r_is_coefficients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `a` float NOT NULL,
  `b` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `k_r_is_coefficients`
--

INSERT INTO `k_r_is_coefficients` (`id`, `name`, `a`, `b`) VALUES
(1, 'Микросхемы интегральные полупроводниковые аналоговые: до 10 элементов', 0.000636, 0.023),
(2, 'Микросхемы интегральные полупроводниковые аналоговые: >10 - 100 элементов', 0.00106, 0.023);

-- --------------------------------------------------------

--
-- Структура таблицы `k_r_kondensator_coefficients`
--

CREATE TABLE IF NOT EXISTS `k_r_kondensator_coefficients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `a` float NOT NULL,
  `b` float NOT NULL,
  `n_t` float NOT NULL,
  `g` float NOT NULL,
  `n_s` float NOT NULL,
  `h` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `k_r_kondensator_coefficients`
--

INSERT INTO `k_r_kondensator_coefficients` (`id`, `name`, `a`, `b`, `n_t`, `g`, `n_s`, `h`) VALUES
(1, 'Керамические, тонкопленочные с неорганическим диэлектриком', 0.0000005909, 14.3, 398, 1, 0.3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `k_r_rezist_coefficients`
--

CREATE TABLE IF NOT EXISTS `k_r_rezist_coefficients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `a` float NOT NULL,
  `b` float NOT NULL,
  `n_t` float NOT NULL,
  `g` float NOT NULL,
  `n_s` float NOT NULL,
  `j` float NOT NULL,
  `h` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `k_r_rezist_coefficients`
--

INSERT INTO `k_r_rezist_coefficients` (`id`, `name`, `a`, `b`, `n_t`, `g`, `n_s`, `j`, `h`) VALUES
(1, 'Постоянные непроволочные: металлодиэлектрические, резисторные сборки, поглотители', 0.26, 0.5078, 343, 9.278, 0.878, 1, 0.886);

-- --------------------------------------------------------

--
-- Структура таблицы `k_r_transformator_coefficients`
--

CREATE TABLE IF NOT EXISTS `k_r_transformator_coefficients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `a` float NOT NULL,
  `g` float NOT NULL,
  `t_m` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `mechanicheskoe_vozdeistvie`
--

CREATE TABLE IF NOT EXISTS `mechanicheskoe_vozdeistvie` (
  `usloviya` varchar(20) NOT NULL,
  `vibraciya` float NOT NULL,
  `udarn_nagr` float NOT NULL,
  `summarnoe` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mechanicheskoe_vozdeistvie`
--

INSERT INTO `mechanicheskoe_vozdeistvie` (`usloviya`, `vibraciya`, `udarn_nagr`, `summarnoe`) VALUES
('лабораторные', 1, 1, 1),
('стационарные', 1.04, 1.03, 1.07),
('автофургонные', 1.35, 1.08, 1.46),
('железнодорожные', 1.4, 1.1, 1.54),
('корабельные', 1.3, 1.05, 1.37),
('самолетные', 1.46, 1.13, 1.65);

-- --------------------------------------------------------

--
-- Структура таблицы `spravochnik`
--

CREATE TABLE IF NOT EXISTS `spravochnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazvanie` varchar(40) NOT NULL,
  `elementtype` varchar(40) NOT NULL,
  `intensivnost` float NOT NULL,
  `int_hran` float NOT NULL,
  `kolichestvo` int(11) NOT NULL,
  `variant` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `название` (`nazvanie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
