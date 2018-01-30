CREATE TABLE IF NOT EXISTS `#__mgt_vehicles`
(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  uniqueid INT NOT NULL,
  srv_id INT NOT NULL,
  type INT NOT NULL,
  bort VARCHAR(7) NOT NULL,
  gos VARCHAR(7) NOT NULL,
  dat TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
CREATE UNIQUE INDEX ildjs_mgt_vehicles_srv_id_bort_uindex ON ildjs_mgt_vehicles (srv_id, bort);
ALTER TABLE `#__mgt_vehicles` COMMENT = 'Подвижной состав МГТ';

ALTER TABLE `#__mgt_online` ADD `srv_id` INT NOT NULL;
CREATE INDEX `#__mgt_online_srv_id_index` ON `#__mgt_online` (srv_id);