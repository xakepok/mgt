<?php
use Joomla\CMS\MVC\Model\ListModel;

defined('_JEXEC') or die;

class MgtModelVehicles extends ListModel
{
    public function __construct(array $config)
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id',
                'uniqueid',
                'srv_id',
                'bort'
            );
        }
        parent::__construct($config);
    }

	public static function getInstance($type, $prefix = '', $config = array())
	{
		return parent::getInstance($type, $prefix, $config); // TODO: Change the autogenerated stub
	}

	public function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query
            ->select("*")
            ->from($db->quoteName("#__mgt_vehicles"));

        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->quote('%' . $db->escape($search, true) . '%', false);
            $query->where($db->quoteName("bort")." LIKE ".$search);
        }

        $orderCol  = $this->state->get('list.ordering', 'id');
        $orderDirn = $this->state->get('list.direction', 'asc');
        $query->order($db->escape($orderCol . ' ' . $orderDirn));

        return $query;
    }

    protected function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);
        parent::populateState('`id`', 'asc');
    }

    protected function getStoreId($id = '')
    {
        $id .= ':' . $this->getState('filter.search');
        return parent::getStoreId($id);
    }
}
