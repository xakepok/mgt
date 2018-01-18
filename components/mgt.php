<?php
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
defined('_JEXEC') or die;

define('VERSION', '1.2.2'); //Версия компонента

require_once JPATH_ADMINISTRATOR.'/components/com_mgt/helpers/mgt.php';

$controller = BaseController::getInstance('mgt');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
