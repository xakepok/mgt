<?php
use Joomla\CMS\MVC\View\HtmlView;
defined('_JEXEC') or die;
class MgtViewMgt extends HtmlView
{
    public $type, $items, $route, $vehicle, $stat, $unique;

    public function display() {
    	try
	    {
		    $input = JFactory::getApplication()->input;
		    $this->route   = $input->getString('route', '');
		    $this->vehicle = $input->getString('vehicle', '');
		    $this->type    = $input->getString('type', '0');
            $this->unique = $input->getBool('unique', false);

            if ($this->route == '' && $this->vehicle == '' && $this->type == '')
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
