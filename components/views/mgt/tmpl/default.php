<?php
use Joomla\CMS\HTML\HTMLHelper;
HTMLHelper::_('script', 'com_mgt/script.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('stylesheet', 'com_mgt/style.css', array('version' => 'auto', 'relative' => true));
?>
<div class="mgt-park">
	<?php echo $this->loadTemplate('result');?>
</div>
<div class="mgt-filter">
    <div><?php echo $this->loadTemplate('filter');?></div>
    <br>
    <div><?php echo $this->loadTemplate('stat');?></div>
    <br>
    <div><?php echo $this->loadTemplate('version');?></div>
</div>
<div class="clear"></div>