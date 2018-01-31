<?php
defined('_JEXEC') or die;

abstract class MgtHtmlFilters
{
	static function getTransport()
	{
		$options = array();
		$options[] = JHtml::_('select.option', '0', JText::_('COM_MGT_FILTER_BUS'));
		$options[] = JHtml::_('select.option', '1', JText::_('COM_MGT_FILTER_TROLL'));
		$options[] = JHtml::_('select.option', '2', JText::_('COM_MGT_FILTER_TRAM'));
		return $options;
	}

	/* Фильтр по акутальности */
	static function transport($selected) {
		$options = array();
		$options[] = JHtml::_('select.option', '', 'COM_MGT_FILTER_SELECT_TRANSPORT');
		$options = array_merge($options, self::getTransport());
		$attribs = 'class="inputbox" onchange="this.form.submit()"';
		return JHtml::_('select.genericlist', $options, 'filter_transport', $attribs, 'value', 'text', $selected, null, true);
	}
}