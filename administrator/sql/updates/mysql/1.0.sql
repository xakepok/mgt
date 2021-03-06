CREATE TABLE IF NOT EXISTS `#__mgt_last_sync` (
  `lastID` int(11) NOT NULL COMMENT 'ID последнего запроса',
  `lastPark` int(11) NOT NULL COMMENT 'Последний парк',
  `lastTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Время последней синхронизации'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Последняя синхронизация';
