<?php
use Joomla\CMS\MVC\View\HtmlView;
defined('_JEXEC') or die;
class MgtViewMgt extends HtmlView
{
    public $park, $items, $route, $vehicle, $stat;

    public function display() {
    	try
	    {
		    $this->items = $this->get('Items');
		    $this->route = JFactory::getApplication()->input->getString('route', '');
		    $this->vehicle = JFactory::getApplication()->input->getString('vehicle', '');
		    $this->park = JFactory::getApplication()->input->getString('park', '');
		    $this->stat = $this->get('Stat');

		    parent::display();
	    }
	    catch (Exception $e)
	    {
		    JFactory::getApplication()->enqueueMessage(JText::_('COM_MGT_ERROR'), 'error');
		    JLog::add($e->getMessage(), JLog::ERROR, 'com_mgt');
	    }
    }
}
