<?php

use Joomla\CMS\MVC\Controller\AdminController;

defined('_JEXEC') or die;

class MgtControllerMgt extends AdminController
{
	/* Установка последнего ID */
	public function setLastID()
	{
		$model = JModelList::getInstance('Mgt', 'MgtModel');
		$result = $model->setLastID();
		if (!$result)
		{
			$msg = JText::_('COM_MGT_MSG_ERROR_SET_LAST_ID: '.$result->stderr());
		}
		else
		{
			$msg = JText::_('COM_MGT_MSG_SUCCESS_SET_LAST_ID');
		}
		$this->setRedirect('index.php?option=com_mgt', $msg);
	}

	/* Очистка таблицы с онлайном за сегодня */
	public function truncateOnline()
	{
		$model = JModelList::getInstance('Mgt', 'MgtModel');
		$result = $model->clearTable();
		if (!$result)
		{
			$msg = JText::_('COM_MGT_MSG_ERROR_TRUNCATE: '.$result->stderr());
		}
		else
		{
			$msg = JText::_('COM_MGT_MSG_TRUNCATE_ONLINE');
		}
		$this->setRedirect('index.php?option=com_mgt', $msg);
	}
}
