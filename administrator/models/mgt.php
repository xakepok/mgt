<?php
use Joomla\CMS\MVC\Model\ListModel;

defined('_JEXEC') or die;

class MgtModelMgt extends ListModel
{
	public static function getInstance($type, $prefix = '', $config = array())
	{
		return parent::getInstance($type, $prefix, $config); // TODO: Change the autogenerated stub
	}

	/* Установка последнего ID */
	public function setLastID()
	{
		$input = JFactory::getApplication()->input;
		$this->id = $input->getInt('uniqueid', false);
		$this->park = $input->getInt('srv_id', false);
		if (!$this->id || !$this->park) return false;

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->update('#__mgt_last_sync')
			->set("`lastID` = '{$this->id}'")
			->set("`lastPark` = '{$this->park}'");
		return $db->setQuery($query)->execute();
	}

	/* Очистка таблицы с онлайном за сегодня */
	public function clearTable()
	{
		$db = JFactory::getDBO();
		$query = "TRUNCATE TABLE `#__mgt_online`";
		return $db->setQuery($query)->execute();
	}

	private $id, $park;
}
