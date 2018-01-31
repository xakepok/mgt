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
				'`r`.`route`'
			);
		}
		parent::__construct($config);
	}

	public function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query
			->select("DATE_FORMAT(`o`.`dat`, '%k.%i') as `dat`, `v`.`bort`, `r`.`route`")
			->from("#__mgt_online_new as `o`")
			->leftJoin("#__mgt_vehicles as `v` ON `v`.`id` = `o`.`vehicle_id`")
			->leftJoin("#__mgt_routes as `r` ON `r`.`id` = `o`.`route_id`")
			->order("`o`.`dat` DESC");

		$transport = $this->getState('filter.transport');
		if (!empty($transport)) {
			$search = $db->quote($transport);
			$query->where($db->quoteName("`v`.`type`")." = ".$search);
		}

		return $query;
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$search = $this->getUserStateFromRequest($this->context . '.filter.transport', 'filter_transport');
		$this->setState('filter.transport', $search);
		parent::populateState('`id`', 'asc');
	}

	protected function getStoreId($id = '')
	{
		$id .= ':' . $this->getState('filter.transport');
		return parent::getStoreId($id);
	}
}
