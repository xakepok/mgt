<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;
class MgtViewVehicles extends HtmlView
{
	protected $helper, $items, $pagination, $state;
	protected $sidebar = '';
	public function display($tpl = null)
	{
		// Show the toolbar
		$this->toolbar();

		// Show the sidebar
		$this->helper = new MgtHelper;
		$this->helper->addSubmenu('vehicles');
		$this->sidebar = JHtmlSidebar::render();

		$this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

		// Display it all
		return parent::display($tpl);
	}

	private function toolbar()
	{
		JToolBarHelper::title(Text::_('COM_MGT_MENU_VEHICLES'), '');

		// Options button.
		if (Factory::getUser()->authorise('core.admin', 'com_mgt'))
		{
		    JToolbarHelper::addNew();
		    JToolbarHelper::editList();
		    JToolbarHelper::deleteList();
			JToolBarHelper::preferences('com_mgt');
		}
	}
}
