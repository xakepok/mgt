<?php
use Joomla\CMS\Table\Table;

defined('_JEXEC') or die;

class TableVehicle extends Table
{
    var $id = null;
    var $uniqueid = null;
    var $srv_id;
    var $type = null;
    var $bort = null;

	public function __construct(JDatabaseDriver $db)
	{
		parent::__construct('#__mgt_vehicles', 'id', $db);
	}
}