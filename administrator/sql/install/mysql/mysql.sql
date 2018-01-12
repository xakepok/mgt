SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Структура таблицы `#__mgt_online`
--

CREATE TABLE IF NOT EXISTS `#__mgt_online` (
  `id` int(11) NOT NULL,
  `dat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - автобус, 1 - троллейбус, 2 - трамвай',
  `vehicle` int(11) NOT NULL COMMENT 'Бортовой номер',
  `route` varchar(8) NOT NULL COMMENT 'Номер маршрута',
  `uniqueid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Онлайн движение МГТ';

-- --------------------------------------------------------

--
-- Структура таблицы `#__mgt_online_archive`
--

CREATE TABLE IF NOT EXISTS `#__mgt_online_archive` (
  `id` int(11) NOT NULL,
  `dat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tip` tinyint(4) NOT NULL DEFAULT '0',
  `vehicle` int(11) NOT NULL COMMENT 'Бортовой номер',
  `route` varchar(6) NOT NULL COMMENT 'Номер маршрута',
  `uniqueid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Онлайн движение МГТ (архив)';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `#__mgt_online`
--
ALTER TABLE `#__mgt_online`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle` (`vehicle`),
  ADD KEY `route` (`route`);

--
-- Индексы таблицы `#__mgt_online_archive`
--
ALTER TABLE `#__mgt_online_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle` (`vehicle`),
  ADD KEY `route` (`route`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `#__mgt_online`
--
ALTER TABLE `#__mgt_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `#__mgt_online_archive`
--
ALTER TABLE `#__mgt_online_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
