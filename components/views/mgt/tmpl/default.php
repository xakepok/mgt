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
    <?php if (!empty($this->stat) && $this->stat !== false): ?>
    <br>
    <div><?php echo $this->loadTemplate('stat');?></div>
    <?php endif; ?>
	<?php if ((bool) MgtHelper::getConfig('show_about', false) !== false): ?>
    <br>
    <div><?php echo $this->loadTemplate('version');?></div>
	<?php endif; ?>
</div>
<div class="clear"></div>