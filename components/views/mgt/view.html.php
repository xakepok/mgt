<?php
use Joomla\CMS\MVC\View\HtmlView;
defined('_JEXEC') or die;
class MgtViewMgt extends HtmlView
{
    public $park, $items, $route, $vehicle, $stat;

    public function display() {
    	try
	    {
            $this->route = JFactory::getApplication()->input->getString('route', '');
            $this->vehicle = JFactory::getApplication()->input->getString('vehicle', '');
            $this->park = JFactory::getApplication()->input->getString('park', '');

            if ($this->route == '' && $this->vehicle == '' && $this->park == '')
            {
                $this->items = array();
            }
            else
            {
                $this->items = $this->get('Items');
            }
		    $this->stat = $this->get('Stat');

		    $this->prepare();

		    parent::display();
	    }
	    catch (Exception $e)
	    {
		    JFactory::getApplication()->enqueueMessage(JText::_('COM_MGT_ERROR').' '.$e->getCode().'.\nFile: '.$e->getFile().'.\nLine: '.$e->getLine().',\nText:'.$e->getMessage(), 'error');
		    JLog::add($e->getMessage(), JLog::ERROR, 'com_mgt');
	    }
    }

    private function prepare()
    {
        JHtml::_('jquery.framework');
    }
}
