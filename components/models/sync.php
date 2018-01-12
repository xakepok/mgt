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
		if ($id['lastPark'] == '1' && $id['lastID'] > 1001750) return array('lastPark' => '3', 'lastID' => '1003000');
		if ($id['lastPark'] == '3' && $id['lastID'] > 1003998) return array('lastPark' => '3', 'lastID' => '1004000');
		if ($id['lastPark'] == '3' && $id['lastID'] > 1004998) return array('lastPark' => '4', 'lastID' => '1004000');
		if ($id['lastPark'] == '4' && $id['lastID'] > 1004998) return array('lastPark' => '8', 'lastID' => '1008000');
		if ($id['lastPark'] == '8' && $id['lastID'] > 1008550) return array('lastPark' => '9', 'lastID' => '1016000');
		if ($id['lastPark'] == '9' && $id['lastID'] > 1016998 && $id['lastID'] < 1017001) return array('lastPark' => '9', 'lastID' => '1017000');
		if ($id['lastPark'] == '9' && $id['lastID'] > 1017800) return array('lastPark' => '11', 'lastID' => '1011000');
		if ($id['lastPark'] == '11' && $id['lastID'] > 1011998) return array('lastPark' => '14', 'lastID' => '1014000');
		if ($id['lastPark'] == '14' && $id['lastID'] > 1014600) return array('lastPark' => '15', 'lastID' => '1015000');
		if ($id['lastPark'] == '15' && $id['lastID'] > 1015998) return array('lastPark' => '17', 'lastID' => '1017000');
		if ($id['lastPark'] == '17' && $id['lastID'] > 1017998) return array('lastPark' => '19', 'lastID' => '1019000');
		if ($id['lastPark'] == '19' && $id['lastID'] > 1019600) return array('lastPark' => '1', 'lastID' => '1001000');
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
					$vehicle = (int) trim(mb_substr($tmp, $num+3, NULL, 'UTF-8'));
					if ($vehicle != 0) $res[$params['uniqueid']]['vehicle'] = $vehicle;
					break;
				}
			}
			if (isset($res[$params['uniqueid']]['vehicle']))
			{
				$tmp = new phpQueryObject($d->find('tbody'));
				$res[$params['uniqueid']]['route'] = false;
				foreach ($d->find("a[href^='?mr_id']") as $fnd)
				{
					$tmp = trim(pq($fnd)->text());
					$res[$params['uniqueid']]['route'] = $tmp;
				}
			}
		}

		if (!empty($res)) {
			$this->exportToBaseMGT($res);
		}
		$last = $start['lastID'] + 50;
		$park = $start['lastPark'];

		$query = "UPDATE `#__mgt_last_sync` SET `lastID` = {$last}, `lastPark` = {$park}";
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$db->query();

		return $res;
	}

	/* Экспортируем записи онлайна МГТ в базу */
	private function exportToBaseMGT($data)
	{
		$db = JFactory::getDbo();
		$query = 'INSERT INTO `#__mgt_online` (`vehicle`, `route`, `uniqueid`) VALUES ';
		$values = array();
		foreach ($data as $item => $value) {
			$route = $value['route'];
			$vehicle = $value['vehicle'];
			if ($vehicle != 0) $values[] = "('{$vehicle}', '{$route}', '{$item}')";
		}
		$query .= implode(',', $values);
		//$query .= " ON DUPLICATE KEY UPDATE `station`=VALUES(`station`), `latence`=VALUES(`latence`), `stamp` = CURRENT_TIMESTAMP()";

		$db->setQuery($query);
		$db->query();

		return true;
	}

	/* Архивирование таблицы МГТ за сутки */
	private function archiveMGT()
	{
		$db = JFactory::getDbo();
		$query = "call archive_mgt_online()";
		$db->setQuery($query);
		$db->query();
		$query = 'call clear_mgt_online()';
		$db->setQuery($query);
		$db->query();
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
