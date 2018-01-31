<?php
use Joomla\CMS\HTML\HTMLHelper;
HTMLHelper::_('script', 'com_mgt/script.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('stylesheet', 'com_mgt/style.css', array('version' => 'auto', 'relative' => true));
?>
<div>
	<?php echo $this->loadTemplate('message');?>
</div>