<?php
use Joomla\CMS\MVC\Model\ListModel;

defined('_JEXEC') or die;
class MgtModelFilter extends ListModel
{
	public function __construct(array $config)
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'`v`.`bort`',
				'`r`.`route`',
                '`v`.`type`',
                'transport',
                'bort',
                'marshrut',
                'date1',
                'date2'
			);
		}

		parent::__construct($config);
	}

	public function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query
			->select("DATE_FORMAT(`o`.`dat`, '%k.%i') as `dat`, IF (`v`.`type`<1, IF(LEFT(`v`.`bort`, 1)='3' OR LEFT(`v`.`bort`, 1)='4' OR LEFT(`v`.`bort`, 2)='10' OR LEFT(`v`.`bort`, 2)='11' OR LEFT(`v`.`bort`, 1)='8', CONCAT('0', `v`.`bort`), `v`.`bort`), `v`.`bort`) as `bort`, `r`.`route`")
			->from("#__mgt_online_new as `o`")
			->leftJoin("#__mgt_vehicles as `v` ON `v`.`id` = `o`.`vehicle_id`")
			->leftJoin("#__mgt_routes as `r` ON `r`.`id` = `o`.`route_id`")
			->order("`o`.`dat` DESC");

        $transport = $this->getUserStateFromRequest($this->context . '.filter.transport', 'filter_transport');
        $bort = $this->getUserStateFromRequest($this->context . '.filter.bort', 'filter_bort');
        $marshrut = $this->getUserStateFromRequest($this->context . '.filter.marshrut', 'filter_marshrut');
        $date1 = $this->getUserStateFromRequest($this->context . '.filter.date1', 'filter_date1');
        $date2 = $this->getUserStateFromRequest($this->context . '.filter.date2', 'filter_date2');

        $this->setState('filter.transport', $transport);
        $this->setState('filter.bort', $bort);
        $this->setState('filter.marshrut', $marshrut);
        $this->setState('filter.date1', $date1);
        $this->setState('filter.date2', $date2);

		$transport = $this->getState('filter.transport');
		$bort = $this->getState('filter.bort');
		$marshrut = $this->getState('filter.marshrut');
		$date1 = $this->getState('filter.date1');
		$date2 = $this->getState('filter.date2');

		if (is_numeric($transport)) {
			$transport = $db->quote($transport);
			$query->where("`v`.`type` = ".$transport);
		}
        if (is_numeric($bort)) {
            if (mb_substr($bort, 0, 1) == '0') $bort = mb_substr($bort, 1);
            $bort = $db->quote('%' . $db->escape($bort, true) . '%', false);
            $query->where("`v`.`bort` LIKE ".$bort);
        }
        if (!empty($marshrut)) {
            $marshrut = $db->quote($db->escape($marshrut, true), false);
            $query->where("`r`.`route` LIKE ".$marshrut);
        }
        if (!empty($date1) && !empty($date2) && MgtHelper::isDate($date1) && MgtHelper::isDate($date2))
        {
            if ($date1 != $date2)
            {
                $date1 = $db->quote($db->escape(date("Y-m-d", strtotime($date1)-86400)));
                $date2 = $db->quote($db->escape(date("Y-m-d", strtotime($date2)+86400)));
                $query->where("`o`.`dat` BETWEEN {$date1} AND {$date2}");
            }
            else
            {
                $dat = $db->quote($db->escape($date1, true) . '%', false);
                $query->where("`o`.`dat` LIKE ".$dat);
            }
        }

		return $query;
	}

	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState('`o`.`dat`', 'asc');
	}

	protected function getStoreId($id = '')
	{
		$id .= ':' . $this->getState('filter.transport');
		$id .= ':' . $this->getState('filter.bort');
		$id .= ':' . $this->getState('filter.marshrut');
		return parent::getStoreId($id);
	}
}
