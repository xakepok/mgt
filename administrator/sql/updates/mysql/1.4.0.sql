CREATE UNIQUE INDEX `#__mgt_vehicles_srv_id_bort_type_uniqueid_uindex` ON `#__mgt_vehicles` (srv_id, bort, type, uniqueid);

CREATE TABLE `#__mgt_routes`
(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  route VARCHAR(8) NOT NULL,
  type TINYINT DEFAULT 0 NOT NULL
);
CREATE UNIQUE INDEX `#__mgt_routes_type_route_uindex` ON `#__mgt_routes` (type, route);

CREATE TABLE `#__mgt_online_new`
(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  dat TIMESTAMP DEFAULT current_timestamp NOT NULL,
  vehicle_id INT NOT NULL,
  route_id INT NOT NULL,
  CONSTRAINT `#__mgt_online_new_#__mgt_vehicles_id_fk` FOREIGN KEY (vehicle_id) REFERENCES `#__mgt_vehicles` (id),
  CONSTRAINT `#__mgt_online_new_#__mgt_routes_id_fk` FOREIGN KEY (route_id) REFERENCES `#__mgt_routes` (id)
);
CREATE INDEX `#__mgt_online_new_vehicle_id_index` ON `#__mgt_online_new` (vehicle_id);
CREATE INDEX `#__mgt_online_new_route_id_index` ON `#__mgt_online_new` (route_id);