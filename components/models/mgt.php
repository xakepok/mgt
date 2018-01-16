<?php
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

defined('_JEXEC') or die;
class MgtModelMgt extends BaseDatabaseModel
{
	public function __construct(array $config = array())
	{
		$this->route = JFactory::getApplication()->input->getString('route', false);
		if ($this->route == '') $this->route = false;
		$this->vehicle = JFactory::getApplication()->input->getString('vehicle', false);
		if ($this->vehicle == '') $this->vehicle = false;
		$this->park = JFactory::getApplication()->input->getString('park', false);
		if ($this->park == '') $this->park = false;
		$this->date_1 = MgtHelper::getDateFromUrl('date_1');
		$this->date_2 = MgtHelper::getDateFromUrl('date_2');
		if (mb_substr($this->vehicle, 0, 1) == '0') $this->vehicle = mb_substr($this->vehicle, 1);
		parent::__construct($config);
	}

	public function getItems()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$table = ($this->date_1 == MgtHelper::getCurrentDate('Y-m-d')) ? '#__mgt_online' : '#__mgt_online_archive';

		$format = ($this->date_1 == $this->date_2) ? '%k.%i' : '%d.%m.%Y %k:%i';

		if ($this->route === false && $this->vehicle === false)
		{
			$query->select('DISTINCT `vehicle`, `route`');
		}
		if ($this->route !== false && $this->vehicle === false)
		{
			$query->select("`vehicle`, `route`, DATE_FORMAT(`dat`, '{$format}') as `dat`");
			$query->where("`route` = '{$this->route}'");
		}
		if ($this->route === false && $this->vehicle !== false)
		{
			$query->select("`vehicle`, `route`, DATE_FORMAT(`dat`, '{$format}') as `dat`");
			$query->where("`vehicle` = '{$this->vehicle}'");
		}
		if ($this->date_1 == $this->date_2)
        {
            $query->where("`dat` LIKE '{$this->date_1}%'");
        }
        else
        {
            $query->where("`dat` BETWEEN '{$this->date_1} 00:00:00' AND '{$this->date_2} 23:59:59'");
        }

		$query->from($table);
		$query->order('`vehicle` ASC, `dat` DESC');
		$db->setQuery($query);

		$res = $db->loadAssocList();

		$arr = array();

		foreach ($res as $item)
		{
			$vehicle = $item['vehicle'];
			if (strlen($item['vehicle']) == 4 || mb_substr($item['vehicle'], 0, 1) == '4' || mb_substr($item['vehicle'], 0, 1) == '3' || mb_substr($item['vehicle'], 0, 2) == '10' || mb_substr($item['vehicle'], 0, 2) == '11') $vehicle = '0'.$item['vehicle'];
			if ($this->park !== false && mb_substr($vehicle, 0, 2) != $this->park) continue;
			if (!empty($item['dat'])) {
				$arr[] = array(
					'vehicle' => $vehicle,
					'route' => $item['route'],
					'dat' => $item['dat']
				);
			}
			else
			{
				$arr[] = array(
					'vehicle' => $vehicle,
					'route' => $item['route'],
				);
			}
		}
		return $arr;
	}

	/* Статистика */
	public function getStat()
	{
		if (!(bool) MgtHelper::getConfig('show_stat', false)) return false;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select("`lastID`, `lastPark`, DATE_FORMAT(`lastTime`, '%k:%i:%s') as `lastTime`")
			->from('#__mgt_last_sync');
		$db->setQuery($query);
		$last = $db->loadAssoc();
		$query = $db->getQuery(true);
		$query
			->select("COUNT(DISTINCT `vehicle`) as `total`")
			->from('#__mgt_online');
		$db->setQuery($query);
		$total = $db->loadResult();
		$last['total'] = $total;

		return $last;
	}

	private $park, $route, $vehicle, $date_1, $date_2;
}
