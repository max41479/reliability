-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 04 2015 г., 12:00
-- Версия сервера: 5.5.28
-- Версия PHP: 5.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `element_types`
--

INSERT INTO `element_types` (`id`, `name`) VALUES
(1, 'Микросхема'),
(2, 'Резистор'),
(3, 'Дроссель'),
(4, 'Диод'),
(5, 'Конденсатор'),
(6, 'Кварцевый генератор'),
(7, 'Вилка'),
(8, 'Клемма приборная'),
(9, 'Тумблер'),
(10, 'Элементы печатной платы с металлизированными отверстиями'),
(11, 'Пайка'),
(12, 'Трансформатор');

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
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `k_r_diod_coefficients`
--

INSERT INTO `k_r_diod_coefficients` (`id`, `name`, `a`, `n_t`, `t_m`, `l`, `delta_t`) VALUES
(1, 'Диоды, кроме стабилитронов, диодные сборки', 44.1025, -2138, 448, 17.7, 150),
(2, 'Cтабилитроны, генераторы шума, ограничители напряжениия', 2.1935, -800, 448, 14, 150),
(3, 'Диоды СВЧ смесительные и детекторные', 0.95, -394, 423, 15.6, 125),
(4, 'Транзисторы биполярные, кроме мощных СВЧ, полевые. Транзисторные сборки. Диоды СВЧ, кроме смесительных и детекторных', 5.2, -1162, 448, 13.8, 150),
(5, 'Тиристоры', 372727, -2050, 448, 9.6, 150);

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
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `k_r_is_coefficients`
--

INSERT INTO `k_r_is_coefficients` (`id`, `name`, `a`, `b`) VALUES
(1, 'Микросхемы интегральные полупроводниковые аналоговые: до 10 элементов', 0.000636, 0.023),
(2, 'Микросхемы интегральные полупроводниковые аналоговые: >10 - 100 элементов', 0.00106, 0.023),
(3, 'Канальные аналоговые ключи', 0.000106, 0.023),
(5, 'Интегральные цифровые (10 -100 элементов)', 0.001632, 0.02079),
(6, 'Интегральный двоичный счетчик', 0.00204, 0.02079);

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
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `k_r_kondensator_coefficients`
--

INSERT INTO `k_r_kondensator_coefficients` (`id`, `name`, `a`, `b`, `n_t`, `g`, `n_s`, `h`) VALUES
(1, 'Керамические, тонкопленочные с неорг. диэл.', 0.000020453, 14.3, 398, 1, 0.3, 3),
(2, 'Стеклянные', 0.000002426, 16, 473, 1, 0.5, 4),
(3, 'Слюдяные', 0.00000009885, 16, 358, 1, 0.4, 3),
(4, 'Бумажные', 0.0569, 2.5, 358, 18, 0.4, 3),
(5, 'Оксидно-электролитические', 0.0359, 4.09, 358, 5.9, 0.55, 3),
(6, 'Оксидно-электролитические(кроме импульсных)', 0.24, 4.09, 398, 5.9, 0.55, 3),
(7, 'Оксидно-электролитические импульсные', 0.2517, 4.09, 358, 5.9, 0, 0),
(8, 'Объемно-пористые', 0.03667, 2.6, 358, 9, 0.4, 3),
(9, 'Оксидно-полупроводниковые', 0.0105, 5.5, 398, 2.5, 0.55, 3),
(10, 'С органическим синтетическим диэлектриком(кроме фторопластовых и высоковольтных импульсных)', 0.055, 2.5, 398, 18, 0.4, 3);

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `k_r_rezist_coefficients`
--

INSERT INTO `k_r_rezist_coefficients` (`id`, `name`, `a`, `b`, `n_t`, `g`, `n_s`, `j`, `h`) VALUES
(1, 'Постоянные непроволочные: металлодиэлектрические, резисторные сборки, поглотители', 0.26, 0.5078, 343, 9.278, 0.878, 1, 0.886),
(2, 'Постоянные непроволочные: композиционные пленочные', 0.06, 1.616, 328, 2.746, 0.622, 1.198, 0.77),
(6, 'переменные проволочные', 0.202, 1.14, 343, 21.7, 0.529, 1, 0.599),
(5, 'Металлодиэлектрические прецизионные', 0.0985, 0.4, 373, 8.643, 0.559, 1.5, 1.147);

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `k_r_transformator_coefficients`
--

INSERT INTO `k_r_transformator_coefficients` (`id`, `name`, `a`, `g`, `t_m`) VALUES
(1, 'Макс. температура 70-85 (класс изол. А)', 0.81, 15.6, 329),
(2, 'Макс. температура 95-105 (класс изол. B)', 0.891, 14, 352),
(3, 'Макс. температура 120-140 (класс изол. C)', 0.894, 8.7, 364),
(4, 'Макс. температура 170 (класс изол. D)', 0.715, 3.8, 398);

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
  `elementtype` varchar(40) NOT NULL COMMENT 'id of element type',
  `intensivnost` float NOT NULL,
  `group_id` int(11) NOT NULL COMMENT 'id of element''s group with determined element''s type',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `название` (`nazvanie`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Дамп данных таблицы `spravochnik`
--

INSERT INTO `spravochnik` (`id`, `nazvanie`, `elementtype`, `intensivnost`, `group_id`) VALUES
(1, 'ADM3202ARN', '1', 0.000000001, 2),
(2, '2C162A', '4', 0.000000004, 2),
(3, 'C29-29B', '2', 0.0000000016, 3),
(4, '544УД1А', '1', 0.0000000016, 2),
(22, 'К155ТМ2', '1', 0.0000000197, 4),
(21, '155ЛА8', '1', 0.0000000197, 4),
(20, '2C156', '4', 0.000000003, 2),
(19, '2Т814', '4', 0.00000005, 4),
(18, 'TA, ТН', '12', 0.000000002, 5),
(10, 'К10-47А-100В', '5', 0.000000047, 1),
(11, 'C2-29B-0.25', '2', 0.000000041, 5),
(12, '590KH4', '1', 0.000000076, 3),
(13, '140УД8', '1', 0.000000047, 2),
(14, 'Д220', '4', 0.000000085, 1),
(15, 'АЛ307Б', '4', 0.000000038, 6),
(24, 'Р1-2', '2', 0.000000053, 1),
(23, 'К155ЛП9', '1', 0.0000000197, 4),
(50, '2А201А*', '4', 0.00000031, 3),
(26, 'K50-15', '5', 0.00000018, 5),
(27, 'К134ЛБ1', '1', 0.00000011, 5),
(28, 'К134ИЕ5', '1', 0.0000000197, 6),
(30, 'КТ807А', '4', 0.000000051, 4),
(31, 'К249ЛП1', '1', 0.00000012, 4),
(32, 'C2-23', '2', 0.000000053, 1),
(33, 'Р1-72', '2', 0.00000003, 2),
(34, 'Пайка волной', '11', 0.000000000069, 0),
(36, 'пайка ручная без накр.', '11', 0.0000000013, 0),
(38, 'Металлиз.  отв.', '10', 0.000000000017, 0),
(39, 'КМ-5а', '5', 0.00000003, 1),
(40, 'СП5-2', '2', 0.000000017, 6),
(41, 'Дроссель фильтра', '3', 0.0000000022, 0),
(42, 'СНП346-6ВП21', '7', 0.000000018, 0),
(43, 'ГПРМ2', '7', 0.000000018, 0),
(44, 'ТА', '12', 0.000000002, 2),
(45, 'ТАН (f= 50 гц)', '12', 0.000000002, 2),
(46, '155ЛА8', '1', 0.0000000197, 5),
(47, 'K134TB14', '1', 0.00000007, 5),
(48, 'К164ЛА7', '1', 0.00000021, 5),
(49, 'К169АА1', '1', 0.00000009, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
