<?php
use Joomla\CMS\HTML\HTMLHelper;
HTMLHelper::_('script', 'com_mgt/script.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('stylesheet', 'com_mgt/style.css', array('version' => 'auto', 'relative' => true));
JHtml::_('behavior.formvalidator');
?>
<div class="mgt-park">
	<?php echo $this->loadTemplate('result');?>
</div>
<div class="mgt-filter">
	<?php echo $this->loadTemplate('filter');?>
</div>
<div class="clear" style="text-align: center"><?php echo $this->pagination->getListFooter(); ?></div>