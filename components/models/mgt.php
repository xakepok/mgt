<?php
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

defined('_JEXEC') or die;
class MgtModelMgt extends BaseDatabaseModel
{
	public function __construct(array $config = array())
	{
		$input = JFactory::getApplication()->input;
		$this->route = $input->getString('route', false);
		if ($this->route == '') $this->route = false;
		$this->vehicle = $input->getString('vehicle', false);
		if ($this->vehicle == '') $this->vehicle = false;
		$this->type = $input->getString('type', '2');
		$this->date_1 = MgtHelper::getDateFromUrl('date_1');
		$this->date_2 = MgtHelper::getDateFromUrl('date_2');
		if (mb_substr($this->vehicle, 0, 1) == '0') $this->vehicle = mb_substr($this->vehicle, 1);
		$this->unique = $input->getBool('unique', false);
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
			$query->select('DISTINCT `vehicle`, `route`, `tip`');
		}
		if ($this->route !== false && $this->vehicle === false)
		{
			$query->select("`vehicle`, `route`, `tip`, DATE_FORMAT(`dat`, '{$format}') as `dat`");
			$query->where("`route` = '{$this->route}'");
		}
		if ($this->route === false && $this->vehicle !== false)
		{
			$query->select("`vehicle`, `route`, `tip`, DATE_FORMAT(`dat`, '{$format}') as `dat`");
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
        $query->where("`tip` = '{$this->type}'");

		$query->from($table);
		$query->order('`vehicle` ASC, `dat` DESC');
		$db->setQuery($query);

		$res = $db->loadAssocList();

		$arr = array();

		foreach ($res as $item)
		{
			$vehicle = $item['vehicle'];
			if ((int) $item['tip'] < 1) {
				if (strlen($item['vehicle']) == 4 || mb_substr($item['vehicle'], 0, 1) == '4' || mb_substr($item['vehicle'], 0, 1) == '3' || mb_substr($item['vehicle'], 0, 2) == '10' || mb_substr($item['vehicle'], 0, 2) == '11') $vehicle = '0'.$item['vehicle'];
			}

			if (!empty($item['dat'])) {
				if ($this->checkUnique($arr, 'vehicle', $vehicle))
				{
					$arr[] = array(
						'vehicle' => $vehicle,
						'route' => $item['route'],
						'dat' => $item['dat'],
						'type' => $item['tip']
					);
				}
			}
			else
			{
				if ($this->checkUnique($arr, 'vehicle', $vehicle))
				{
					$arr[] = array(
						'vehicle' => $vehicle,
						'route' => $item['route'],
						'type' => $item['tip']
					);
				}
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

	private function checkUnique($array, $key, $key_value)
	{
		if ($this->unique)
		{
			return ($this->is_in_array($array, $key, $key_value) == 'yes') ? false : true;
		}
		else
		{
			return true;
		}
	}

	private function is_in_array($array, $key, $key_value){
		$within_array = 'no';
		foreach( $array as $k=>$v ){
			if( is_array($v) ){
				$within_array = $this->is_in_array($v, $key, $key_value);
				if( $within_array == 'yes' ){
					break;
				}
			} else {
				if( $v == $key_value && $k == $key ){
					$within_array = 'yes';
					break;
				}
			}
		}
		return $within_array;
	}

	private $type, $route, $vehicle, $date_1, $date_2, $unique;
}
