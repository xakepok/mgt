<?php
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

class MgtHelper
{
	public function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(Text::_('COM_MGT'), 'index.php?option=com_mgt&view=mgt', $vName == 'mgt');
	}

	static function dump($data)
	{
		if (JFactory::getUser()->authorise('core.manage', 'com_mgt')) return "<pre>".var_dump($data)."</pre>";
	}

	/*
	 * Конвертируем бортовой номер
	 * $to - куда конвертируем
	 * $to == 'view' - на сайт
	 * $to == 'base' - в базу
	 * $bort - бортовой номер
	 * */
	static function convertBort($to, $bort)
	{
		if ($to == 'view')
		{
			if (strlen($bort) == 4 || mb_substr($bort, 0, 1) == '4' || mb_substr($bort, 0, 1) == '3' || mb_substr($bort, 0, 2) == '10' || mb_substr($bort, 0, 2) == '11') $bort = '0'.$bort;
		}
		return $bort;
	}

	/* Получение даты из УРЛ */
	static function getDateFromUrl($varName = 'date')
	{
		$dat = JFactory::getApplication()->input->getString($varName, false);
		return (!$dat || !self::isDate($dat)) ? self::getCurrentDate("Y-m-d") : $dat;
	}

	/* Получаем текущую дату */
	static function getCurrentDate($format)
	{
		return date($format);
	}

	/* Валидность даты */
	static function isDate($dat)
	{
		return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dat);
	}

	/* Получаем конфиг */
	static function getConfig($param, $default)
	{
		$config = JComponentHelper::getParams('com_mgt');
		return $config->get($param, $default);
	}
}
