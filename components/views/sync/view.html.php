<?php
use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

class MgtViewSync extends HtmlView
{
	public $text;
	public function display($tpl = null)
	{
		$this->text = $this->get('Sync');
		return parent::display($tpl);
	}
}
