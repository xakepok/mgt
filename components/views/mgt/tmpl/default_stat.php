<?php echo "<p>", JText::_('COM_MGT_STAT_SYNC'), ":</p>"; ?>
<div class="mgt-stat">
	<?php if ((bool) MgtHelper::getConfig('show_stat_last_time', false) !== false && !empty($this->stat['lastTime'])) echo JText::_('COM_MGT_STAT_SYNC_TIME'), ": ", $this->stat['lastTime'], "<br>"; ?>
	<?php if ((bool) MgtHelper::getConfig('show_stat_last_id', false) !== false && !empty($this->stat['lastID'])) echo JText::_('COM_MGT_STAT_SYNC_UNIQUEID'), ": ", $this->stat['lastID'], "<br>"; ?>
	<?php echo JText::_('COM_MGT_STAT_SYNC_TOTAL'), ": ", $this->stat['total']; ?>
</div>
