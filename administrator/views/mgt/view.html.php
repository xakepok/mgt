<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;
class MgtViewMgt extends HtmlView
{
	protected $helper;
	protected $sidebar = '';
	public function display($tpl = null)
	{
		// Show the toolbar
		$this->toolbar();

		// Show the sidebar
		$this->helper = new MgtHelper;
		$this->helper->addSubmenu('mgt');
		$this->sidebar = JHtmlSidebar::render();

		// Display it all
		return parent::display($tpl);
	}

	private function toolbar()
	{
		JToolBarHelper::title(Text::_('COM_MGT'), '');

		// Options button.
		if (Factory::getUser()->authorise('core.admin', 'com_mgt'))
		{
			JToolbarHelper::custom('mgt.truncateOnline','','', JText::_('COM_MGT_BUTTON_CLEAR_LABEL'));
			JToolBarHelper::preferences('com_mgt');
		}
	}
}
