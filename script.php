<?php
defined('_JEXEC') or die;

class Com_MgtInstallerScript
{
	public function __construct(JAdapterInstance $adapter)
	{

	}

	public function preflight($route, JAdapterInstance $adapter)
	{

	}

	public function postflight($route, JAdapterInstance $adapter)
	{
		$link = JRoute::_('index.php?option=com_config&view=component&component=com_mgt');
		echo JHtml::link($link, JText::_('COM_MGT_LINK_SETUP'));
	}

	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install(JAdapterInstance $adapter) {}

	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function update(JAdapterInstance $adapter) {}

	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	public function uninstall(JAdapterInstance $adapter)
	{
		$db = JFactory::getDbo();
		$drop = "DROP TABLE `#__mgt_online`, `#__mgt_online_archive`, `#__mgt_routes`, `#__mgt_vehicles`";
		$db->setQuery($drop);
		return $db->query();
	}
}
