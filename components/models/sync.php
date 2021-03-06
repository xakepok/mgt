<?php
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

defined('_JEXEC') or die;
class MgtModelSync extends BaseDatabaseModel
{
	public function __construct(array $config = array())
	{
		$this->config = JComponentHelper::getParams('com_mgt');
		parent::__construct($config);
	}

	/* Синхронизируем */
	public function getSync()
	{
		$archive = (bool) JFactory::getApplication()->input->getInt('archive', 0);
		if (!$archive)
		{
			return $this->syncMGT();
		}
		else
		{
			return $this->archiveMGT();
		}
	}

	/*  Определение старта МГТ */
	private function getStartId()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('`lastPark`, `lastID`')
			->from('#__mgt_last_sync');
		$db->setQuery($query, 0, 1);
		$id = $db->loadAssoc();
		if ($id['lastPark'] == '1' && $id['lastID'] > 100550 && $id['lastID'] < 1003001) return array('lastPark' => '1', 'type'=>0, 'lastID' => '1003000');
		if ($id['lastPark'] == '1' && $id['lastID'] > 1001750) return array('lastPark' => '3', 'type'=>0, 'lastID' => '1003000');
		if ($id['lastPark'] == '3' && $id['lastID'] > 1003998 && $id['lastID'] < 1004001) return array('lastPark' => '3', 'type'=>0, 'lastID' => '1004000');
		if ($id['lastPark'] == '3' && $id['lastID'] > 1004998) return array('lastPark' => '4', 'type'=>0, 'lastID' => '1004000');
		if ($id['lastPark'] == '4' && $id['lastID'] > 1004998) return array('lastPark' => '8', 'type'=>0, 'lastID' => '1001000');
		if ($id['lastPark'] == '8' && $id['lastID'] > 1001998 && $id['lastID'] < 1008001) return array('lastPark' => '8', 'type'=>0, 'lastID' => '1008000');
		if ($id['lastPark'] == '8' && $id['lastID'] > 1008550) return array('lastPark' => '9', 'type'=>0, 'lastID' => '1016000');
		if ($id['lastPark'] == '9' && $id['lastID'] > 1016998 && $id['lastID'] < 1017001) return array('lastPark' => '9', 'type'=>0, 'lastID' => '1017000');
		if ($id['lastPark'] == '9' && $id['lastID'] > 1017800) return array('lastPark' => '11', 'type'=>0, 'lastID' => '1011000');
		if ($id['lastPark'] == '11' && $id['lastID'] > 1011998) return array('lastPark' => '14', 'type'=>0, 'lastID' => '1014000');
		if ($id['lastPark'] == '14' && $id['lastID'] > 1014600) return array('lastPark' => '15', 'type'=>0, 'lastID' => '1015000');
		if ($id['lastPark'] == '15' && $id['lastID'] > 1016100) return array('lastPark' => '17', 'type'=>0, 'lastID' => '1017000');
		if ($id['lastPark'] == '17' && $id['lastID'] > 1017998) return array('lastPark' => '19', 'type'=>0, 'lastID' => '1019000');
		if ($id['lastPark'] == '19' && $id['lastID'] > 1019600) return array('lastPark' => '204', 'type'=>2, 'lastID' => '1203000');
		if ($id['lastPark'] == '204' && $id['lastID'] > 1204800) return array('lastPark' => '1', 'type'=>0, 'lastID' => '100000');
		return $id;
	}

	/* Синхронизация МГТ */
	private function syncMGT()
	{
		$login = $this->config->get('login');
		$password = $this->config->get('password');
		$address = $this->config->get('url');
		if (empty($login) || empty($password) || empty($address)) return JText::_('COM_MGT_ERROR_SYNC_EMPTY_SETTINGS');
		if (!$this->checkTime()) return JText::_('COM_MGT_INFO_SYNC_NOT_TIME');
		jimport('phpQuery-onefile');
		$res = array();
		$start = $this->getStartId();

		for ($i = $start['lastID']; $i < $start['lastID']+50; $i++)
		{
			$params = array(
				'srv_id' => $start['lastPark'],
				'uniqueid' => $i
			);
			$url = "http://{$login}:{$password}@{$address}?".http_build_query($params);

			$d = phpQuery::newDocumentHtml(file_get_contents($url));

			$tmp = new phpQueryObject($d->find('head'));
			foreach ($d->find("h1") as $fnd) {
				$tmp = trim(pq($fnd)->text());
				$num = mb_stripos($tmp, ' / ');
				if ($num !== false)
				{
					$vehicle = (int) ($start['lastPark'] < 20) ? trim(mb_substr($tmp, $num+3, NULL, 'UTF-8')) : trim(mb_substr($tmp, $num-5, 5));
					if ($vehicle != 0) $res[$params['uniqueid']]['vehicle'] = $vehicle;
					break;
				}
			}
			if (isset($res[$params['uniqueid']]['vehicle']))
			{
				$tmp = new phpQueryObject($d->find('tbody'));
				$res[$params['uniqueid']]['route'] = false;
				$res[$params['uniqueid']]['srv_id'] = $start['lastPark'];
				foreach ($d->find("a[href^='?mr_id']") as $fnd)
				{
					$tmp = trim(pq($fnd)->text());
					if ($start['lastPark'] > 19) //Для троллейбусов и трамваев
					{
						$t = explode('.', $tmp);
						$tmp = $t[1];
					}
					$res[$params['uniqueid']]['route'] = $tmp;
					$res[$params['uniqueid']]['type'] = ($start['lastPark'] < 20) ? '0' : '2';
				}
			}
		}

		if (!empty($res)) {
			$this->insertRoutes($res);
			$this->insertVehicles($res);
			$data = $this->prepare($res);
			if ($data !== false) $this->exportToBaseMGT($data);
		}
		$last = $start['lastID'] + 50;
		$park = $start['lastPark'];

		$query = "UPDATE `#__mgt_last_sync` SET `lastID` = {$last}, `lastPark` = {$park}";
		$db = JFactory::getDbo();
		$db->setQuery($query)->execute();


		return $res;
	}

	/* Экспортируем записи онлайна МГТ в базу */
	private function exportToBaseMGT($data)
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$columns = array($db->quoteName("vehicle_id"), $db->quoteName("route_id"));
		$query
			->insert($db->quoteName("#__mgt_online_new"))
			->columns($columns);
		foreach ($data as $item)
		{
			$query
				->values($item['vehicle'].", ".$item['route']);
		}

		return $db->setQuery($query)->execute();
	}

	/* Подготавливаем данные для вставки */
	private function prepare($data)
	{
		$db =& $this->getDbo();
		$db->setUtf();
		$query = $db->getQuery(true);
		$vehicles = array();
		$srv_ids = array();
		$unique_ids = array();
		$routes = array();
		$type = 0;

		foreach ($data as $item => $value)
		{
			$vehicles[] = $db->quote($value['vehicle']);
			$srv_ids[] = $db->quote($value['srv_id']);
			$unique_ids[] = $db->quote($item);
			$routes[] = $db->quote($value['route']);
			$type = $db->quote($value['type']);
		}
		$srv_ids = array_unique($srv_ids);
		$vehicles = implode(', ', $vehicles);
		$srv_ids = implode(', ', $srv_ids);
		$unique_ids = implode(', ', $unique_ids);
		$routes = implode(', ', $routes);

		$query
			->select("*")
			->from($db->quoteName("#__mgt_vehicles"))
			->where($db->quoteName("bort")." IN ({$vehicles})")
			->where($db->quoteName("srv_id")." IN ({$srv_ids})")
			->where($db->quoteName("uniqueid")." IN ({$unique_ids})");
		$vehicles = $db->setQuery($query)->loadAssocList('uniqueid');

		$db->setUtf();
		$query = $db->getQuery(true);
		$query
			->select("*")
			->from($db->quoteName("#__mgt_routes"))
			->where($db->quoteName("route")." IN ({$routes})")
			->where($db->quoteName("type")." = {$type}");
		$routes = $db->setQuery($query)->loadAssocList('route');

		$result = array();
		foreach ($data as $item => $value)
		{
			$result[] = array(
				'vehicle' => $db->quote($vehicles[$item]['id']),
				'route' => $db->quote($routes[$value['route']]['id'])
			);
		}
		return (!empty($result)) ? $result : false;
	}

	/* Вставляем маршрут в базу */
	private function insertVehicles($data)
	{
		$db = $this->getDbo();
		$query = 'INSERT INTO `#__mgt_vehicles` (`uniqueid`, `srv_id`, `type`, `bort`) VALUES ';
		$values = array();
		foreach ($data as $item => $value) {
			$vehicle = $value['vehicle'];
			$tip = $value['type'];
			$srv_id = $value['srv_id'];
			if ($vehicle != 0) $values[] = "('{$item}', '{$srv_id}', '{$tip}', '{$vehicle}')";
		}
		$query .= implode(',', $values);

		$query .= " ON DUPLICATE KEY UPDATE `uniqueid`=VALUES(`uniqueid`), `srv_id`=VALUES(`srv_id`), `type`=VALUES(`type`), `bort`=VALUES(`bort`)";

		$db->setQuery($query)->execute();
	}

	/* Вставляем ТС в базу */
	private function insertRoutes($data)
	{
		$db = $this->getDbo();
		$query = 'INSERT INTO `#__mgt_routes` (`type`, `route`) VALUES ';
		$values = array();
		foreach ($data as $item => $value) {
			$route = $value['route'];
			$tip = $value['type'];
			if ($route !== 0) $values[] = "('{$tip}', '{$route}')";
		}
		$query .= implode(',', $values);

		$query .= " ON DUPLICATE KEY UPDATE `type`=VALUES(`type`), `route`=VALUES(`route`)";

		$db->setQuery($query)->execute();
	}

	/* Архивирование таблицы МГТ за сутки */
	private function archiveMGT()
	{
		$db = JFactory::getDbo();
		$query = "call archive_mgt_online()";
		$db->setQuery($query)->execute();

		$query = 'call clear_mgt_online()';
		$db->setQuery($query)->execute();

		return true;
	}

	/* Проверка времени синхронизации */
	private function checkTime()
	{
		$hours = explode(',', $this->config->get('hourses'));
		return in_array((string) date("G"), $hours) && (bool) $this->config->get('enabled');
	}

	private $config;
}
